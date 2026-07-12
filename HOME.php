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
    <div class="section dropdown active-nav">
      <a href="home.php">🏠 HOME</a>
    </div>
    
    <div class="section dropdown">
      <a href="Games.php">🎮 GAMES</a>
      <div class="dropdown-content">
        <a href="register-game.php">Register New</a>
        <a href="Games.php#gameplay">Gameplay</a>
      </div>
    </div>

    <div class="section dropdown">
       <a href="players.html">👤 PLAYERS</a>
       <div class="dropdown-content">
          <a href="profile.php">My Profile</a>
          <a href="logout.php" style="color: #ff006a;">LOGOUT</a>
       </div>
    </div> 
  </header>

  <h2 style="text-align: center; color: white; font-size: 45px; margin-top: 80px; text-shadow: 0 0 15px rgba(0, 0, 0, 0.8); letter-spacing: 3px;">WELCOME</h2>
  
  <div style="text-align: center; color: white; margin-top: 20px;">
      <h3 style="font-family: 'BBH'; opacity: 0.8;">
          Welcome back, <?php echo htmlspecialchars($_SESSION['active_user']); ?>!
      </h3>
  </div>

  <div style="background: rgba(0,0,0,0.5); color: #00ffcc; padding: 10px; margin: 30px auto; width: 80%; border-radius: 5px; overflow: hidden; border: 1px solid #00ffcc;">
      <marquee behavior="scroll" direction="left" scrollamount="5">
          ⚡ NEWS: New gameplay trailers added for ENDFIELD and WUTHERING WAVES! | Stay tuned for the upcoming tournament! | Server status: ONLINE
      </marquee>
  </div>

  <div style="display: flex; justify-content: center; gap: 20px; margin-top: 50px;">
      <a href="Games.php" class="quick-card">BROWSE GAMES</a>
      <a href="register-game.php" class="quick-card">REGISTER A GAME</a>
  </div>

  <br>

<script>
    // Background Video Persistence Logic
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