<?php 
session_start();
if(!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Selection</title>
  <link rel="stylesheet" href="../CSS/style2.css">
</head>
<body>

  <video autoplay muted loop class="bg-video">
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
  <div class="FORM">
      <form action="save_game.php" method="POST">
          <h3>REGISTER GAME</h3>
          
          <div class="input-group">
              <label for="playerName">Player Name</label>
              <input type="text" name="player_name" id="playerName" placeholder="Player Name" required autocomplete="off">
          </div>
          
          <div class="input-group">
              <label for="gameSelect">Select Game</label>
              <select name="game_select" id="gameSelect" required>
                  <option value="" disabled selected>Choose a Game</option>
                  <option value="Arknights Endfield">Endfield</option>
                  <option value="Wuthering Waves">WUWA</option>
                  <option value="Zenless Zone Zero">ZZZ</option>
                  <option value="Honkai: Star Rail">HSR</option>
                  <option value="Palworld">palworld</option>
                  <option value="Valorant">valorant</option> 
              </select>
          </div>

          <button type="submit">CONFIRM</button>
      </form>
  </div>

<script>
    const video = document.querySelector('.bg-video');
    window.addEventListener('DOMContentLoaded', () => {
        const savedTime = localStorage.getItem('bgVideoTime');
        if (savedTime) video.currentTime = parseFloat(savedTime); 
    });
    window.addEventListener('beforeunload', () => {
        localStorage.setItem('bgVideoTime', video.currentTime);
    });
</script>
</body>
</html>
