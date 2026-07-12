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
  <style>
    .FORM {
      backdrop-filter: blur(10px);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%); 
      margin: 0 !important;
      width: 320px; 
      padding: 35px 25px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
      color: rgb(255, 255, 255); 
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
    }

    .FORM form {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }

    .FORM h3 {
      text-align: center; 
      width: 100%;
      margin: 0 0 15px 0;
      letter-spacing: 2px;
    }

    .FORM .input-group {
      display: flex;
      flex-direction: column;
      align-items: center; 
      width: 100%;            
      margin: 10px 0;
    }

    .FORM label {
      font-size: 11px;
      letter-spacing: 1px;
      margin-bottom: 6px;
      color: #ffffff;
      font-weight: bold;
      text-transform: uppercase;
      text-align: center; 
      width: 100%;
    }

    .FORM input, 
    .FORM select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      box-sizing: border-box;
      font-size: 14px;
      text-align: center;      
      text-align-last: center; 
    }

    .FORM button {
      width: 100%;
      border-radius: 8px;
      padding: 12px;
      border: 1px solid #ccc;
      box-shadow: 0 0 20px rgba(0,0,0,0.8);
      margin-top: 25px; 
      font-weight: bold;
      cursor: pointer;
      background: #fff;
      color: #000;
      transition: 0.3s ease;
      box-sizing: border-box;
    }

    .FORM button:hover {
      transform: translateY(-3px);
      background-color: #ff006a;
      color: white; 
      border-color: #ff006a;
    }
  </style>
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
