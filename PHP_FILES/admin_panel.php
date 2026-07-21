<?php
session_start();

// 1. ADMIN AUTHENTICATION SETUP
$admin_username = "admin";
$admin_password = "password123"; // Change this to your desired admin password
$admin_error = "";

// Handle Admin Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_login_submit'])) {
    if ($_POST['admin_user'] === $admin_username && $_POST['admin_pass'] === $admin_password) {
        $_SESSION['is_admin'] = true;
    } else {
        $admin_error = "<div style='color:red; text-align:center; margin-bottom: 15px;'>Access Denied. Invalid credentials.</div>";
    }
}

// Handle Admin Logout
if (isset($_GET['admin_logout'])) {
    unset($_SESSION['is_admin']);
    header("Location: admin_panel.php");
    exit;
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "games_showcase";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$message = "";
$active_tab = "upload"; // Default tab

// ==========================================
// LOGIC: HANDLE VOTING RESET
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_voting'])) {
    $conn->query("UPDATE games_poll SET votes = 0");
    $conn->query("TRUNCATE TABLE user_votes");
    $message = "<div class='success-msg'>Voting has been successfully reset! All users can vote again.</div>";
    $active_tab = "voting"; 
}

// --- LOGIC: HANDLE NEWS UPLOAD ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_news'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $active_tab = "upload";
    
    $target_dir = "../UPLOADS/"; 
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = basename($_FILES["news_image"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name; 
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    if(in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
        if (move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $content, $target_file);
            if($stmt->execute()) {
                $message = "<div class='success-msg'>Transmission successfully uploaded.</div>";
            }
            $stmt->close();
        }
    } else {
        $message = "<div class='error-msg'>Only JPG, JPEG, PNG, WEBP & GIF files are allowed.</div>";
    }
}

// --- LOGIC: HANDLE NEWS EDIT/UPDATE ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_news'])) {
    $news_id = intval($_POST['news_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $active_tab = "manage"; 

    $stmt = null; 

    if (!empty($_FILES["news_image"]["name"])) {
        $target_dir = "../UPLOADS/"; 
        $file_name = basename($_FILES["news_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name; 
        
        if (move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
            $stmt_old = $conn->prepare("SELECT image_path FROM news WHERE id = ?");
            $stmt_old->bind_param("i", $news_id);
            $stmt_old->execute();
            $result_old = $stmt_old->get_result();
            if ($row = $result_old->fetch_assoc()) {
                if (file_exists($row['image_path'])) { unlink($row['image_path']); }
            }
            $stmt_old->close();

            $stmt = $conn->prepare("UPDATE news SET title=?, content=?, image_path=? WHERE id=?");
            $stmt->bind_param("sssi", $title, $content, $target_file, $news_id);
        }
    } else {
        $stmt = $conn->prepare("UPDATE news SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $news_id);
    }
    
    if ($stmt) {
        if($stmt->execute()) {
            $message = "<div class='success-msg'>Transmission successfully updated.</div>";
        }
        $stmt->close();
    }
}

// --- LOGIC: HANDLE NEWS DELETION ---
if (isset($_GET['delete_news'])) {
    $news_id = intval($_GET['delete_news']);
    $active_tab = "manage";
    
    $stmt = $conn->prepare("SELECT image_path FROM news WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (file_exists($row['image_path'])) { unlink($row['image_path']); }
    }
    $stmt->close();
    
    $stmt2 = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt2->bind_param("i", $news_id);
    if($stmt2->execute()) { $message = "<div class='success-msg'>Transmission deleted.</div>"; }
    $stmt2->close();
}

// --- LOGIC: HANDLE USER DELETION (FROM users TABLE) ---
if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $active_tab = "players";
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if($stmt->execute()) { 
        $message = "<div class='success-msg'>User deleted successfully from users table.</div>"; 
    } else {
        $message = "<div class='error-msg'>Error deleting user: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// Check if we are currently editing a specific news item
$edit_data = null;
if (isset($_GET['edit_news'])) {
    $active_tab = "edit";
    $edit_id = intval($_GET['edit_news']);
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch Data for Tables (Using SELECT * FROM users for players directory)
$users_result = $conn->query("SELECT * FROM users ORDER BY id DESC");
$news_result = $conn->query("SELECT id, title, created_at FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Control Center</title>
  <link rel="stylesheet" href="../CSS/style2.css">
</head>
<body>

  <video autoplay muted loop class="bg-video" style="position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; z-index: -1; object-fit: cover;">
    <source src="../TEMPLATES_FILE/videoplayback (1).mp4" type="video/mp4">
  </video>

  <header class="header">
  </header>

  <?php if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true): ?>
      <!-- ==========================================
           ADMIN LOGIN SCREEN
           ========================================== -->
      <div class="admin-login-box">
          <h2 style="color: #ff006a; margin-bottom: 20px; text-shadow: 0 0 10px #ff006a;">ADMIN ACCESS</h2>
          <?php echo $admin_error; ?>
          <form method="POST" action="admin_panel.php">
              <input type="text" name="admin_user" placeholder="Admin Username" required autocomplete="off">
              <input type="password" name="admin_pass" placeholder="Admin Password" required>
              <button type="submit" name="admin_login_submit" class="admin-btn" style="width: 90%;">AUTHENTICATE</button>
          </form>
      </div>

  <?php else: ?>
      <!-- ==========================================
           ADMIN DASHBOARD SCREEN
           ========================================== -->
      <div class="dashboard-wrapper">
          
          <!-- SIDEBAR NAVIGATION -->
          <div class="sidebar">
              <div class="sidebar-title">CONTROL PANEL</div>
              <button class="tab-btn <?php echo ($active_tab == 'upload') ? 'active' : ''; ?>" onclick="openTab('upload_tab', this)">Upload News</button>
              <button class="tab-btn <?php echo ($active_tab == 'manage') ? 'active' : ''; ?>" onclick="openTab('manage_tab', this)">Manage News</button>
              <?php if($edit_data): ?>
                <button class="tab-btn <?php echo ($active_tab == 'edit') ? 'active' : ''; ?>" onclick="openTab('edit_tab', this)">Edit Transmission</button>
              <?php endif; ?>
              <button class="tab-btn <?php echo ($active_tab == 'players') ? 'active' : ''; ?>" onclick="openTab('players_tab', this)">Manage Players</button>
              <button class="tab-btn <?php echo ($active_tab == 'voting') ? 'active' : ''; ?>" onclick="openTab('voting_tab', this)">Manage Voting</button>
          </div>

          <!-- MAIN CONTENT AREA -->
          <div class="content-area">
              <?php echo $message; ?>

              <!-- TAB 1: UPLOAD NEWS -->
              <div id="upload_tab" class="tab-content <?php echo ($active_tab == 'upload') ? 'active' : ''; ?>">
                  <h2>Upload New Transmission</h2>
                  <form class="admin-form" action="admin_panel.php" method="POST" enctype="multipart/form-data">
                      <label>Headline / Title</label>
                      <input type="text" name="title" required placeholder="e.g. Wuthering Waves Update 1.1">
                      
                      <label>Article Content</label>
                      <textarea name="content" required placeholder="Write the news article here..."></textarea>
                      
                      <label>Thumbnail Image</label>
                      <input type="file" name="news_image" accept="image/*" required>
                      
                      <button type="submit" name="upload_news" class="admin-btn">PUBLISH NEWS</button>
                  </form>
              </div>

              <!-- TAB 2: MANAGE NEWS -->
              <div id="manage_tab" class="tab-content <?php echo ($active_tab == 'manage') ? 'active' : ''; ?>">
                  <h2>Manage Published Transmissions</h2>
                  <table class="data-table">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Title</th>
                              <th>Date Published</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if($news_result && $news_result->num_rows > 0): ?>
                              <?php while($news = $news_result->fetch_assoc()): ?>
                                  <tr>
                                      <td><?php echo $news['id']; ?></td>
                                      <td><?php echo htmlspecialchars($news['title']); ?></td>
                                      <td><?php echo date('M j, Y - g:i A', strtotime($news['created_at'])); ?></td>
                                      <td>
                                          <a href="admin_panel.php?edit_news=<?php echo $news['id']; ?>" class="action-btn edit-btn">EDIT</a>
                                          <a href="admin_panel.php?delete_news=<?php echo $news['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Permanently delete this news?');">DELETE</a>
                                      </td>
                                  </tr>
                              <?php endwhile; ?>
                          <?php else: ?>
                              <tr><td colspan="4">No news transmissions found.</td></tr>
                          <?php endif; ?>
                      </tbody>
                  </table>
              </div>

              <!-- TAB 3: EDIT NEWS -->
              <?php if($edit_data): ?>
              <div id="edit_tab" class="tab-content <?php echo ($active_tab == 'edit') ? 'active' : ''; ?>">
                  <h2>Edit Transmission: <?php echo htmlspecialchars($edit_data['title']); ?></h2>
                  <form class="admin-form" action="admin_panel.php" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="news_id" value="<?php echo $edit_data['id']; ?>">
                      
                      <label>Headline / Title</label>
                      <input type="text" name="title" required value="<?php echo htmlspecialchars($edit_data['title']); ?>">
                      
                      <label>Article Content</label>
                      <textarea name="content" required><?php echo htmlspecialchars($edit_data['content']); ?></textarea>
                      
                      <label>Current Thumbnail</label>
                      <div style="margin-bottom: 15px;">
                          <img src="<?php echo htmlspecialchars($edit_data['image_path']); ?>" alt="Current Image" style="max-height: 100px; border-radius: 5px; border: 1px solid #ff006a;">
                      </div>
                      
                      <label>Upload New Thumbnail (Leave blank to keep current image)</label>
                      <input type="file" name="news_image" accept="image/*">
                      
                      <button type="submit" name="update_news" class="admin-btn" style="background: #ffcc00;">UPDATE NEWS</button>
                      <a href="admin_panel.php" class="admin-btn" style="background: #555; color: white; text-decoration: none; margin-left: 10px;">CANCEL</a>
                  </form>
              </div>
              <?php endif; ?>

              <!-- TAB 4: MANAGE PLAYERS (FROM users table) -->
              <div id="players_tab" class="tab-content <?php echo ($active_tab == 'players') ? 'active' : ''; ?>">
                  <h2>Registered Users Directory (users table)</h2>
                  <table class="data-table">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Username</th>
                              <th>Password</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if($users_result && $users_result->num_rows > 0): ?>
                              <?php while($user = $users_result->fetch_assoc()): ?>
                                  <tr>
                                      <td><?php echo $user['id']; ?></td>
                                      <td><?php echo htmlspecialchars($user['username']); ?></td>
                                      <td><?php echo isset($user['password']) ? htmlspecialchars($user['password']) : 'N/A'; ?></td>
                                      <td>
                                          <a href="admin_panel.php?delete_user=<?php echo $user['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Permanently delete user <?php echo htmlspecialchars($user['username']); ?>?');">DELETE</a>
                                      </td>
                                  </tr>
                              <?php endwhile; ?>
                          <?php else: ?>
                              <tr><td colspan="4">No users found in database.</td></tr>
                          <?php endif; ?>
                      </tbody>
                  </table>
              </div>

              <!-- TAB 5: MANAGE VOTING -->
              <div id="voting_tab" class="tab-content <?php echo ($active_tab == 'voting') ? 'active' : ''; ?>">
                  <h2>Voting Administration</h2>
                  <p style="color: #aaa; margin-bottom: 20px;">Use this control to wipe all current votes and reset the poll back to zero. This will allow all users to vote again.</p>
                  
                  <form method="POST" action="admin_panel.php" onsubmit="return confirm('WARNING: This will permanently delete all votes and reset the poll to 0. Are you absolutely sure?');">
                      <button type="submit" name="reset_voting" class="admin-btn" style="background: #cc0000; color: white; border: 2px solid #ff0000;">
                          ⚠️ RESET ALL VOTES TO ZERO
                      </button>
                  </form>
              </div>

          </div>
      </div>

      <script>
          function openTab(tabId, btnElement) {
              document.querySelectorAll('.tab-content').forEach(function(tab) {
                  tab.classList.remove('active');
              });
              document.querySelectorAll('.tab-btn').forEach(function(btn) {
                  btn.classList.remove('active');
              });
              document.getElementById(tabId).classList.add('active');
              btnElement.classList.add('active');
          }
      </script>
  <?php endif; ?>

</body>
</html>