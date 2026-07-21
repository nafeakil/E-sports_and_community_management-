<?php 
session_start();

// 1. SECURITY CHECK: Make sure user is actually logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { 
    header("Location: login.php"); 
    exit; 
} 

// 2. GET CURRENT USER (Matches what login_check.php sets)
if (isset($_SESSION['active_user'])) {
    $current_user = $_SESSION['active_user'];
} else {
    $current_user = 'UnknownPlayer';
}

$db_host = 'localhost';
$db_user = 'root';        
$db_pass = '';            
$db_name = 'games_showcase'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) { die("Database Connection Failed: " . $conn->connect_error); }

$message = "";

// 4. CHECK IF USER HAS ALREADY VOTED
$check_user_sql = "SELECT * FROM user_votes WHERE username = '" . $conn->real_escape_string($current_user) . "'";
$result = $conn->query($check_user_sql);
$has_voted = ($result->num_rows > 0); 

// 5. HANDLE VOTE SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
    if ($current_user === 'UnknownPlayer') {
        $message = "<div style='color:red; text-align:center; font-weight:bold; margin-bottom:15px;'>ERROR: System cannot identify your account. Please re-login.</div>";
    } 
    elseif (!$has_voted) {
        $game_id = $conn->real_escape_string($_POST['game_id']);
        
        // Add 1 vote to the game
        $conn->query("UPDATE games_poll SET votes = votes + 1 WHERE game_id = '$game_id'");
        
        // Lock the exact user so they can't vote again
        $conn->query("INSERT INTO user_votes (username) VALUES ('" . $conn->real_escape_string($current_user) . "')");
        
        header("Location: voting.php?success=1");
        exit;
    } else {
        $message = "<div style='color:#ff006a; text-align:center; font-weight:bold; margin-bottom:15px; text-shadow: 0 0 5px #ff006a;'>ERROR: YOU HAVE ALREADY CAST YOUR VOTE!</div>";
    }
}

// 6. FETCH GAMES AND CALCULATE TOTAL VOTES
$games_list = [];
$total_votes = 0;
$games_result = $conn->query("SELECT * FROM games_poll ORDER BY votes DESC");

if ($games_result->num_rows > 0) {
    while($row = $games_result->fetch_assoc()) {
        $games_list[] = $row;
        $total_votes += $row['votes'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Popularity Poll</title>
  <link rel="stylesheet" href="../CSS/style2.css">
  <style>
      .poll-container {
          width: 70%; 
          margin: 120px auto 40px auto; 
          background: rgba(0, 0, 0, 0.85);
          padding: 30px; 
          border-radius: 10px; 
          border: 1px solid #ff006a; 
          color: white;
          box-shadow: 0 0 15px rgba(255, 0, 106, 0.2);
      }
      .game-row {
          display: flex; align-items: center; gap: 20px; background: rgba(17, 17, 17, 0.9);
          padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #333;
      }
      .game-img { width: 120px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ff006a; }
      .game-info { flex-grow: 1; }
      .game-title { font-size: 1.2rem; font-weight: bold; margin-bottom: 5px; display: flex; justify-content: space-between; text-transform: uppercase;}
      .bar-bg { width: 100%; background: #222; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 10px; border: 1px solid #444;}
      .bar-fill { background: #ff006a; height: 100%; transition: width 0.5s ease-in-out; box-shadow: 0 0 10px #ff006a;}
      .vote-btn {
          background: transparent; color: #ff006a; border: 1px solid #ff006a;
          padding: 10px 25px; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s;
          text-transform: uppercase; letter-spacing: 1px;
      }
      .vote-btn:hover:not(:disabled) { background: #ff006a; color: white; box-shadow: 0 0 10px #ff006a; }
      .vote-btn:disabled { border-color: #555; color: #555; cursor: not-allowed; background: transparent; box-shadow: none; }
  </style>
</head>
<body>

  <!-- BACKGROUND VIDEO -->
  <video autoplay muted loop class="bg-video">
    <source src="../TEMPLATES_FILE/videoplayback (1).mp4" type="video/mp4">
  </video>

  <!-- NAVIGATION HEADER -->
  <header class="header">
    <div class="section dropdown">
      <a href="home.php">HOME</a>
      <div class="dropdown-content">
        <a href="news.php">game-news</a>
        <a href="voting.php">vote-games</a>
      </div>
    </div>
    
    <div class="section dropdown">
      <a href="Games.php">GAMES</a>
      <div class="dropdown-content">
        <a href="register-game.php">REGISTER-GAME</a>
        <a href="GAMEPLAY.php">GAMEPLAY</a>
        <a href="download_game.php">DOWNLOAD</a>
      </div>
    </div>
    <div class="section dropdown"><a href="players.php">PLAYERS</a>
    <div class="dropdown-content">
        <a href="logout.php">LOGOUT</a>
    </div>
    </div> 
  </header>

  <!-- POLL CONTENT -->
  <div class="poll-container">
      <h1 style="text-align:center; color:#ff006a; margin-bottom: 5px; text-shadow: 0 0 10px #ff006a; text-transform: uppercase; letter-spacing: 2px;">VOTE FOR YOUR FAVORITE GAME</h1>
      
      <!-- Displays who the system thinks is voting -->
      <p style="text-align:center; color:#aaa; margin-bottom: 25px;">Logged in as: <span style="color:#fff; font-weight:bold;"><?php echo htmlspecialchars($current_user); ?></span></p>
      
      <?php 
          if(isset($_GET['success'])) echo "<div style='color:#0f0; text-align:center; font-weight:bold; margin-bottom:20px; text-shadow: 0 0 5px #0f0; text-transform: uppercase;'>VOTE REGISTERED SUCCESSFULLY</div>";
          echo $message; 
      ?>

      <?php foreach ($games_list as $game): ?>
          <?php $percentage = ($total_votes > 0) ? round(($game['votes'] / $total_votes) * 100) : 0; ?>
          
          <div class="game-row">
              <img src="<?php echo htmlspecialchars($game['image_path']); ?>" class="game-img" alt="Game Thumbnail">
              
              <div class="game-info">
                  <div class="game-title">
                      <span><?php echo htmlspecialchars($game['title']); ?></span>
                      <span style="color:#ff006a;"><?php echo $percentage; ?>%</span>
                  </div>
                  <div class="bar-bg">
                      <div class="bar-fill" style="width: <?php echo $percentage; ?>%;"></div>
                  </div>
              </div>
              
              <form method="POST" style="margin: 0;">
                  <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                  <?php if ($has_voted): ?>
                      <button type="button" class="vote-btn" disabled>VOTED</button>
                  <?php else: ?>
                      <button type="submit" class="vote-btn">VOTE</button>
                  <?php endif; ?>
              </form>
          </div>
          
      <?php endforeach; ?>
  </div>

  <script>
      const video = document.querySelector('.bg-video');
      window.addEventListener('DOMContentLoaded', () => {
          if(!video) return; // Prevents errors if video is missing
          const savedTime = localStorage.getItem('bgVideoTime');
          if (savedTime) {
              video.currentTime = parseFloat(savedTime);
          }
      });
      window.addEventListener('beforeunload', () => {
          if(video) localStorage.setItem('bgVideoTime', video.currentTime);
      });
  </script>

</body>
</html>