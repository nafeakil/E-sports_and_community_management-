<?php 
session_start();
if(!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "games_showcase";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Fetch news from the database securely
$news_query = "SELECT * FROM news ORDER BY created_at DESC";
$news_result = $conn->query($news_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Games Showcase - News</title>
  <link rel="stylesheet" href="../CSS/style2.css">
</head>
<body>

  <video autoplay muted loop class="bg-video" style="position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; z-index: -1; object-fit: cover;">
    <source src="../TEMPLATES_FILE/videoplayback (1).mp4" type="video/mp4">
  </video>

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

  <h2 style="text-align: center; color: white; font-size: 45px; margin-top: 80px;">TRANSMISSION LOGS</h2>

  <div class="search-container">
      <input type="text" id="newsSearch" placeholder="Search Transmissions" autocomplete="off" style="width: 50%; padding: 10px; margin: 20px auto; display: block; border-radius: 20px; border: none; outline: none;">
  </div>

  <div class="news-container" id="newsFeed">
      <?php if ($news_result->num_rows > 0): ?>
          <?php while($row = $news_result->fetch_assoc()): ?>
              <div class="news-card">
                  <div class="img-report-wrapper">
                      <span class="news-time-badge">UPDATED: <?php echo date('M j, Y - g:i A', strtotime($row['created_at'])); ?></span>
                      <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="News Image" class="news-image">
                  </div>
                  <div class="news-content">
                      <h3 class="news-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                      <p class="news-text"><?php echo htmlspecialchars($row['content']); ?></p>
                  </div>
              </div>
          <?php endwhile; ?>
      <?php else: ?>
          <p style="color: white; text-align: center; grid-column: 1 / -1;">No transmissions found.</p>
      <?php endif; ?>
  </div>

  <script>
      const searchInput = document.getElementById('newsSearch');
      const newsCards = document.querySelectorAll('.news-card');

      searchInput.addEventListener('input', function() {
          const query = this.value.toLowerCase();
          newsCards.forEach(card => {
              const title = card.querySelector('.news-title').textContent.toLowerCase();
              const text = card.querySelector('.news-text').textContent.toLowerCase();
              card.style.display = (title.includes(query) || text.includes(query)) ? 'flex' : 'none';
          });
      });
  </script>
</body>
</html>