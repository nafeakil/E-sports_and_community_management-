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
  <title>Games Showcase</title>
  <link rel="stylesheet" href="../CSS/style2.css">
</head>
<body>

  <video autoplay muted loop class="bg-video">
    <source src="../TEMPLATES_FILE/videoplayback (1).mp4" type="video/mp4">
  </video>

  <header class="header">
  <div class="section dropdown">
    <a href="home.html">HOME</a>
    <div class="dropdown-content">
      <a href="#">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
    </div>
  </div>
  
  <div class="section dropdown">
    <a href="Games.php">GAMES</a>
    <div class="dropdown-content">
      <a href="register-game.php">REGISTER-GAME</a>
      <a href="#">GAMEPLAY</a>
      <a href="#">3</a>
    </div>
  </div>
  <div class="section dropdown"><a href="players.html">PLAYERS</a>
  <div class="dropdown-content">
      <a href="logout.php">LOGOUT</a>
  </div>
  </div> 
</header>
<h2 style="text-align: center; color: white; font-size: 45px; margin-top: 80px; text-shadow: 0 0 15px rgba(0, 0, 0, 0.8); letter-spacing: 3px;">WELCOME</h2>
  <br>

<script>
    const video = document.querySelector('.bg-video');
    window.addEventListener('DOMContentLoaded', () => {
        const savedTime = localStorage.getItem('bgVideoTime');
        if (savedTime) {
            video.currentTime = parseFloat(savedTime);
        }
    });
    window.addEventListener('beforeunload', () => {
        localStorage.setItem('bgVideoTime', video.currentTime);
    });
</script>
</body>
</html>