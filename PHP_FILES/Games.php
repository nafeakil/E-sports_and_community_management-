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
      <a href="news.php">game-news</a>
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
  <div class="section dropdown"><a href="players.php">PLAYERS</a>
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

<div style="text-align: center; margin-bottom: 20px;">
  <input type="text" id="gameSearch" placeholder="Search" autocomplete="off" style="padding: 10px; width: 600px; border-radius: 8px; border: none; background: rgba(255, 255, 255, 0.9); font-size: 14px; text-align: center; box-shadow: 0 0 15px rgba(0,0,0,0.8); outline: none; font-weight: bold;">
</div>
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
      <img src="../TEMPLATES_FILE/palworld.png" alt="ZZZ">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/PALWORLD.mp4" type="video/mp4">
    </video>
    <h2>Palworld</h2>
  </div>

  <div class="game right">
    <div class="card">
      <img src="../TEMPLATES_FILE/VALORANT.png" alt="VALORANT">
    </div>
    <video class="preview" autoplay muted loop controls>
      <source src="../TEMPLATES_FILE/VALORANT.mp4" type="video/mp4">
    </video>
    <h2>VALORANT</h2>
  </div>
</div>

<br>

<script>
    // --- BACKGROUND VIDEO LOGIC ---
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

    // --- UPDATED SEARCH LOGIC ---
    const searchInput = document.getElementById('gameSearch');
    const rows = document.querySelectorAll('.row');

    searchInput.addEventListener('input', function() {
        const filterText = this.value.toLowerCase();
        
        rows.forEach(row => {
            const gamesInRow = row.querySelectorAll('.game');
            let visibleGames = [];

            gamesInRow.forEach(game => {
                const gameTitle = game.querySelector('h2').innerText.toLowerCase();
                if (gameTitle.includes(filterText)) {
                    game.style.display = ''; 
                    visibleGames.push(game); 
                } else {
                    game.style.display = 'none'; 
                }
            });

            if (visibleGames.length === 0) {
                row.style.display = 'none';
            } else {
                row.style.display = 'flex';
              
                if (visibleGames.length === 1) {
                    visibleGames[0].classList.remove('right');
                    visibleGames[0].classList.add('left');
                } else if (visibleGames.length === 2) {
                    visibleGames[0].classList.remove('right');
                    visibleGames[0].classList.add('left');
                    visibleGames[1].classList.remove('left');
                    visibleGames[1].classList.add('right');
                }
            }
        });
    });
</script>
</body>
</html>