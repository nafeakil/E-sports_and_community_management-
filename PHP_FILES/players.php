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

$active_user = $_SESSION['active_user'];

// Fetch Registered Games
$games_stmt = $conn->prepare("SELECT id, selected_game FROM game_registrations WHERE player_name = ?");
$games_stmt->bind_param("s", $active_user);
$games_stmt->execute();
$games_result = $games_stmt->get_result();

$registered_games = [];
while($row = $games_result->fetch_assoc()) {
    $registered_games[] = $row;
}
$games_stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <link rel="stylesheet" href="../CSS/style2.css">
  <style>
    body { background: radial-gradient(circle, #1a1a1a 0%, #000 100%); margin: 0; min-height: 100vh; color: white; font-family: sans-serif;}
    .profile-container {
        background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
        width: 90%; max-width: 1000px; margin: 100px auto 50px auto; padding: 40px; border-radius: 15px;
        display: flex; gap: 40px;
    }
    .left-col { flex: 1; }
    .right-col { flex: 1; background: rgba(0,0,0,0.4); padding: 25px; border-radius: 10px; }
    
    .user-header { display: flex; align-items: center; margin-bottom: 30px; }
    .avatar {
        width: 80px; height: 80px; border-radius: 50%; display: flex; justify-content: center; align-items: center;
        font-size: 30px; font-weight: bold; background-color: #ff006a; margin-right: 20px; color: white; flex-shrink: 0;
    }
    .user-info h2 { margin: 0; text-transform: uppercase; font-size: 24px; }
    
    .game-card { 
        background: rgba(0,0,0,0.5); padding: 15px; border-radius: 8px; margin-bottom: 10px; 
        border-left: 4px solid #ff006a; cursor: pointer; transition: 0.3s;
    }
    .game-card:hover { background: rgba(255, 0, 106, 0.2); transform: translateX(5px); }
    
    .settings-form { display: flex; flex-direction: column; gap: 15px; }
    .settings-form input, .settings-form select { padding: 10px; border-radius: 5px; border: none; outline: none; background: #fff; }
    .btn { padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s; }
    .btn-update { background: #00ffcc; color: black; }
    .btn-update:hover { background: #00ccaa; }
    .btn-danger { background: transparent; border: 1px solid #ff0044; color: #ff0044; margin-top: 10px; }
    .btn-danger:hover { background: #ff0044; color: white; }

    /* New style to make the heading look clickable */
    .toggle-heading { cursor: pointer; user-select: none; transition: 0.3s; display: inline-block; }
    .toggle-heading:hover { text-shadow: 0 0 8px #ff006a; }

    .side-panel {
        position: fixed; top: 0; right: -400px; width: 350px; height: 100vh;
        background: rgba(15, 15, 15, 0.98); border-left: 2px solid #00ffcc;
        box-shadow: -5px 0 20px rgba(0,0,0,0.8); transition: right 0.4s ease;
        padding: 30px; z-index: 1000; color: white; backdrop-filter: blur(10px);
        box-sizing: border-box; display: flex; flex-direction: column; overflow-y: auto;
    }
    .side-panel.open { right: 0; }
    .close-btn { cursor: pointer; color: #ff006a; font-size: 30px; align-self: flex-end; line-height: 1; }
    
    .panel-img { width: 100%; border-radius: 8px; border: 1px solid #333; margin: 15px 0; object-fit: cover; height: 180px; }
    .panel-title { font-size: 24px; text-transform: uppercase; margin: 0 0 10px 0; color: #00ffcc; }
    .panel-desc { color: #ccc; font-size: 14px; margin-bottom: 30px; line-height: 1.5; }
  </style>
</head>
<body>

  <header class="header">
      <div class="section dropdown"><a href="home.php">HOME</a></div>
      <div class="section dropdown"><a href="Games.php">GAMES</a></div>
      <div class="section dropdown"><a href="players.php">PLAYERS</a>
      <div class="dropdown-content"><a href="logout.php">LOGOUT</a></div>
      </div> 
  </header>

  <div class="profile-container">
      <div class="left-col">
          <div class="user-header">
              <div class="avatar"><?php echo strtoupper(substr($active_user, 0, 1)); ?></div>
              <div class="user-info">
                  <h2><?php echo htmlspecialchars($active_user); ?></h2>
              </div>
          </div>

          <h3 style="color: #00ffcc;">My Squads</h3>
          <?php if (count($registered_games) > 0): ?>
              <?php foreach($registered_games as $game): ?>
                  <div class="game-card" onclick="openGamePanel(<?php echo $game['id']; ?>, '<?php echo addslashes($game['selected_game']); ?>')">
                      <?php echo htmlspecialchars($game['selected_game']); ?>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <p style="color: #ccc;">No games registered yet.</p>
          <?php endif; ?>
      </div>

      <div class="right-col">
          <h3 style="color: #ff006a; margin-top: 0;">Account</h3>
          <form action="players_action.php" method="POST" class="settings-form">
              <input type="hidden" name="action" value="update">
              <input type="text" name="new_username" placeholder="New Username" autocomplete="off">
              <input type="password" name="new_password" placeholder="New Password">
              <button type="submit" class="btn btn-update">SAVE CHANGES</button>
          </form>

          <?php if (count($registered_games) > 0): ?>
              <h3 style="color: #ff006a; margin-top: 30px;" class="toggle-heading" onclick="toggleGameManager()">
                  Manage Games <span id="toggleIcon" style="font-size: 14px; margin-left: 5px;"></span>
              </h3>
              
              <form action="game_action.php" method="POST" class="settings-form" id="manageGameForm" style="display: none;">
                  <select name="registration_id" required>
                      <?php foreach($registered_games as $game): ?>
                          <option value="<?php echo $game['id']; ?>"><?php echo htmlspecialchars($game['selected_game']); ?></option>
                      <?php endforeach; ?>
                  </select>
                  <select name="new_game" required>
                      <option value="Arknights Endfield">Arknights Endfield</option>
                      <option value="Wuthering Waves">Wuthering Waves</option>
                      <option value="Zenless Zone Zero">Zenless Zone Zero</option>
                      <option value="Honkai: Star Rail">Honkai: Star Rail</option>
                      <option value="Palworld">Palworld</option>
                      <option value="Valorant">Valorant</option>
                  </select>
                  <button type="submit" name="action" value="change" class="btn btn-update">UPDATE REGISTRATION</button>
              </form>
          <?php endif; ?>

          <form action="players_action.php" method="POST" style="margin-top: 20px;">
              <input type="hidden" name="action" value="delete">
              <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm account deletion?');">DELETE ACCOUNT</button>
          </form>
      </div>
  </div>

  <div id="gamePanel" class="side-panel">
      <span class="close-btn" onclick="closeGamePanel()">&times;</span>
      <img id="panelImg" src="" alt="Game Banner" class="panel-img">
      <h2 id="panelTitle" class="panel-title"></h2>
      <p id="panelDesc" class="panel-desc"></p>
      <form action="game_action.php" method="POST" class="settings-form">
          <input type="hidden" name="registration_id" id="panelRegId">
          <button type="submit" name="action" value="unregister" class="btn btn-danger">UNREGISTER</button>
      </form>
  </div>

  <script>
      const gameDatabase = {
          "Arknights Endfield": { img: "../TEMPLATES_FILE/endfield.png", desc: "Deploy your operators and explore a vast, dangerous world in this 3D real-time strategic RPG." },
          "Wuthering Waves": { img: "../TEMPLATES_FILE/wuwa.png", desc: "Awaken in a new world. Master deep combat mechanics and absorb echoes in this action-packed open-world RPG." },
          "Zenless Zone Zero": { img: "../TEMPLATES_FILE/zzz.png", desc: "Welcome to New Eridu. Dive into the Hollows and experience hyper-stylized urban combat." },
          "Honkai: Star Rail": { img: "../TEMPLATES_FILE/hsr.png", desc: "Hop aboard the Astral Express and explore the galaxy in this space fantasy RPG." },
          "Palworld": { img: "../TEMPLATES_FILE/palworld.png", desc: "Fight, farm, build and work alongside mysterious creatures called Pals in this multiplayer, open-world survival and crafting game." },
          "Valorant": { img: "../TEMPLATES_FILE/VALORANT.png", desc: "Blend your style and experience on a global, competitive stage in this 5v5 character-based tactical shooter." }
      };

      function openGamePanel(regId, gameName) {
          document.getElementById('panelRegId').value = regId;
          document.getElementById('panelTitle').textContent = gameName;
          if (gameDatabase[gameName]) {
              document.getElementById('panelImg').src = gameDatabase[gameName].img;
              document.getElementById('panelDesc').textContent = gameDatabase[gameName].desc;
              document.getElementById('panelImg').style.display = 'block';
          } else {
              document.getElementById('panelImg').style.display = 'none'; 
              document.getElementById('panelDesc').textContent = "Registration data verified.";
          }
          document.getElementById('gamePanel').classList.add('open');
      }

      function closeGamePanel() { 
          document.getElementById('gamePanel').classList.remove('open'); 
      }

      function toggleGameManager() {
          const form = document.getElementById('manageGameForm');
          const icon = document.getElementById('toggleIcon');
          
          if (form.style.display === 'none') {
              form.style.display = 'flex';
              icon.textContent = '';
          } else {
              form.style.display = 'none';
              icon.textContent = '';
          }
      }
  </script>
</body>
</html>