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
  <title>Gameplay - Games Showcase</title>
  
  <!-- The cache-busting PHP trick is added here to force CSS updates -->
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

  <br>
  <div class="title-box">
    Gameplay - Showcase
  </div>

  <div class="showcase-container">
      <div class="search-wrapper">
         <input type="text" id="gameSearch" placeholder="Search" autocomplete="off" style="color: white; width: 50%; padding: 10px; margin: 20px auto; display: block; border-radius: 20px; border: none; outline: none;">
      </div>

      <!-- MANUAL HTML GRID -->
      <div class="games-grid" id="gamesContainer">
          
          <!-- GAME 1: ENDFIELD -->
          <div class="game-card" data-title="arknights: endfield">
              <h2>ARKNIGHTS: ENDFIELD</h2>
              <video id="vid-endfield" muted loop controls>
                  <source src="../TEMPLATES_FILE/ENDFIELD_COMBAT.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-endfield', '../TEMPLATES_FILE/ENDFIELD_COMBAT.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-endfield', '../TEMPLATES_FILE/ENDFIElD_MECHANICS.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-endfield', '../TEMPLATES_FILE/Endfield_WORLD.mp4')">WORLD</button>
              </div>
              <!-- needed change -->
          </div>

          <!-- GAME 2: WUTHERING WAVES -->
          <div class="game-card" data-title="wuthering waves">
              <h2>WUTHERING WAVES</h2>
              <video id="vid-wuwa" muted loop controls>
                  <source src="../TEMPLATES_FILE/wuwa_combat.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-wuwa', '../TEMPLATES_FILE/wuwa_combat.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-wuwa', '../TEMPLATES_FILE/wuwa_mechanics.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-wuwa', '../TEMPLATES_FILE/wuwa_world.mp4')">WORLD</button>
              </div>
          </div>

          <!-- GAME 3: ZENLESS ZONE ZERO -->
          <div class="game-card" data-title="zenless zone zero">
              <h2>ZENLESS ZONE ZERO</h2>
              <video id="vid-zzz" muted loop controls>
                  <source src="../TEMPLATES_FILE/zzz_combat.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-zzz', '../TEMPLATES_FILE/zzz_combat.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-zzz', '../TEMPLATES_FILE/ZenlessZoneZero_mechanics.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-zzz', '../TEMPLATES_FILE/ZenlessZoneZero_exploration.mp4')">WORLD</button>
              </div>
          </div>

          <!-- GAME 4: HONKAI STAR RAIL -->
          <div class="game-card" data-title="honkai star rail">
              <h2>HONKAI STAR RAIL</h2>
              <video id="vid-hsr" muted loop controls>
                  <source src="../TEMPLATES_FILE/Honkai_ Star Rail_combat.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-hsr', '../TEMPLATES_FILE/Honkai_ Star Rail_combat.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-hsr', '../TEMPLATES_FILE/Honkai_ Star Rail_mechanics.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-hsr', '../TEMPLATES_FILE/Honkai_ Star Rail_exploration.mp4')">WORLD</button>
              </div>
          </div>

          <!-- GAME 5: PALWORLD -->
          <div class="game-card" data-title="palworld">
              <h2>PALWORLD</h2>
              <video id="vid-palworld" muted loop controls>
                  <source src="../TEMPLATES_FILE/pal_combat.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-palworld', '../TEMPLATES_FILE/pal_combat.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-palworld', '../TEMPLATES_FILE/pal_mechanics.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-palworld', '../TEMPLATES_FILE/pal_exploration.mp4')">WORLD</button>
              </div>
          </div>

          <!-- GAME 6: VALORANT -->
          <div class="game-card" data-title="valorant">
              <h2>VALORANT</h2>
              <video id="vid-valorant" muted loop controls>
                  <source src="../TEMPLATES_FILE/valo_combat.mp4" type="video/mp4">
              </video>
              <div class="video-controls">
                  <button class="ui-btn active" onclick="switchVideo(this, 'vid-valorant', '../TEMPLATES_FILE/valo_combat.mp4')">COMBAT</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-valorant', '../TEMPLATES_FILE/VALORANT_mechanic.mp4')">MECHANIC</button>
                  <button class="ui-btn" onclick="switchVideo(this, 'vid-valorant', '../TEMPLATES_FILE/VALORANT_world.mp4')">WORLD</button>
              </div>
          </div>

      </div>
  </div>
  <br><br>

<script>
    // --- SLEEK UI VIDEO SWITCHING ---
    function switchVideo(button, videoId, newSrc) {
        const videoElement = document.getElementById(videoId);
        const sourceElement = videoElement.querySelector('source');
        
        sourceElement.src = newSrc;
        videoElement.load();
        videoElement.play(); 

        const container = button.parentElement;
        const allButtons = container.querySelectorAll('.ui-btn');
        allButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
    }

    // --- SNAPPY SEARCH FILTER ---
    const searchInput = document.getElementById('gameSearch');
    const gameCards = document.querySelectorAll('.game-card');

    searchInput.addEventListener('input', function() {
        const filterText = this.value.toLowerCase();
        
        gameCards.forEach(card => {
            const title = card.getAttribute('data-title');
            if (title.includes(filterText)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // --- BACKGROUND VIDEO PERSISTENCE ---
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