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
  <title>Download Center</title>
  
  <link rel="stylesheet" href="../CSS/style2.css?v=<?php echo time(); ?>">
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
      <a href="#">3</a>
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
    Download Center
  </div>
  
  <br>

  <!-- Search Bar -->
  <div style="text-align: center; margin-bottom: 20px;">
     <input type="text" id="newsSearch" placeholder="Search" autocomplete="off" style="width: 50%; padding: 10px; margin: 20px auto; display: block; border-radius: 20px; border: none; outline: none;">
  </div>

  <!-- Download Grid Container -->
  <div class="download-grid" id="downloadGrid">
      
      <!-- GAME 1 -->
      <a href="https://launcher.hg-cdn.com/TiaytKBUIEdoEwRT/launcher/1.5.0/6/6/hv3A5kLWqSyBCMjr/GRYPHLINK_v1.5.0.1507_6_6_endfield.exe" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/endfield.png" alt="Arknights Endfield">
              </div>
              <h2>ARKNIGHTS: ENDFIELD</h2>
          </div>
      </a>

      <!-- GAME 2 -->
      <a href="https://mirrors-package-mc.aki-game.net/client/download/20260626225349_cBTo1dy6HNogkayVUp/WutheringWaves_overseas_setup_2.6.3.0.exe" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/wuwa.png" alt="Wuthering Waves">
              </div>
              <h2>WUTHERING WAVES</h2>
          </div>
      </a>

      <!-- GAME 3 -->
      <a href="https://download-porter.hoyoverse.com/download-porter/2026/05/29/ZenlessZoneZero_setup_202605091625.exe?trace_key=ZenlessZoneZero_install_ua_c4531063ac72" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/zzz.png" alt="Zenless Zone Zero">
              </div>
              <h2>ZENLESS ZONE ZERO</h2>
          </div>
      </a>

      <!-- GAME 4 -->
      <a href="https://download-porter.hoyoverse.com/download-porter/2026/05/26/4.3_0526_setup_hoyoverse.exe?trace_key=StarRail_setup_ua_af912d0d7d00" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/hsr.png" alt="Honkai Star Rail">
              </div>
              <h2>HONKAI STAR RAIL</h2>
          </div>
      </a>

      <!-- GAME 5 -->
      <a href="https://store.steampowered.com/app/1623730/Palworld/" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/palworld.png" alt="Palworld">
              </div>
              <h2>PALWORLD</h2>
          </div>
      </a>

      <!-- GAME 6 -->
      <a href="https://playvalorant.com/en-us/platform-selection/" download class="download-link">
          <div class="dl-game">
              <div class="dl-card">
                  <img src="../TEMPLATES_FILE/VALORANT.png" alt="Valorant">
              </div>
              <h2>VALORANT</h2>
          </div>
      </a>

  </div>

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

    // --- SEARCH LOGIC (Updated for Grid Layout) ---
    const searchInput = document.getElementById('gameSearch');
    const downloadLinks = document.querySelectorAll('.download-link');

    searchInput.addEventListener('input', function() {
        const filterText = this.value.toLowerCase();
        
        downloadLinks.forEach(link => {
            const gameTitle = link.querySelector('h2').innerText.toLowerCase();
            
            // If the title matches, show it as a block. If not, hide it completely.
            if (gameTitle.includes(filterText)) {
                link.style.display = 'block'; 
            } else {
                link.style.display = 'none'; 
            }
        });
    });
</script>
</body>
</html>