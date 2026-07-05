<?php 
session_start();
// Security check: Kicks them to login if they aren't signed in
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
  <title>Games</title>
  
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
<br>

<div class="title-box">
  Gameplay - Trailer
</div>
<br>

<div class="row">
  <div class="game left">
    <div class="card">
      <img src="../TEMPLATES_FILE/endfield.png" alt="Endfield">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/ENDFIELD - Trim.mp4" type="video/mp4">
    </video>
    <br>
    <h2>ARKNIGHTS: ENDFIELD</h2>
  </div>

  <div class="game right">
    <div class="card">
      <img src="../TEMPLATES_FILE/wuwa.png" alt="Wuthering Waves">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/WUWA.mp4" type="video/mp4">
    </video>
    <br>
    <h2>WUTHERING WAVES</h2>
  </div>
</div>

<br>

<div class="row">
  <div class="game left">
    <div class="card">
      <img src="../TEMPLATES_FILE/zzz.png" alt="ZZZ">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/zzz.mp4" type="video/mp4">
    </video>
    <br>
    <h2>ZENLESS ZONE ZERO</h2>
  </div>

  <div class="game right">
    <div class="card">
      <img src="../TEMPLATES_FILE/hsr.png" alt="HSR">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/HSR.mp4" type="video/mp4">
    </video>
    <br>
    <h2>HONKAI STAR RAIL</h2>
  </div>
</div>

<br>

<div class="row">
  <div class="game left">
    <div class="card">
      <img src="../TEMPLATES_FILE/zzz.png" alt="ZZZ">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/zzz.mp4" type="video/mp4">
    </video>
    <h2>Palworld</h2>
  </div>

  <div class="game right">
    <div class="card">
      <img src="../TEMPLATES_FILE/hsr.png" alt="HSR">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/HSR.mp4" type="video/mp4">
    </video>
    <h2>VALORANT</h2>
  </div>
</div>

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