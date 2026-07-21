<?php
session_start();
if(!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

// Connect to the database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "games_showcase";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$current_user = $_SESSION['active_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        
        $new_username = trim($_POST['new_username']);
        $new_password = $_POST['new_password'];

        // Handle Username Change
        if (!empty($new_username) && $new_username !== $current_user) {
            $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $check->bind_param("s", $new_username);
            $check->execute();
            
            if ($check->get_result()->num_rows == 0) {
                // Update username in users
                $stmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
                $stmt->bind_param("ss", $new_username, $current_user);
                $stmt->execute();
                
                $stmt2 = $conn->prepare("UPDATE game_registrations SET player_name = ? WHERE player_name = ?");
                $stmt2->bind_param("ss", $new_username, $current_user);
                $stmt2->execute();
                
                $_SESSION['active_user'] = $new_username;
                $current_user = $new_username;
            } else {
                echo "<script>alert('That username is already taken!'); window.location.href='players.php';</script>";
                exit();
            }
        }

        if (!empty($new_password)) {
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_password, $current_user);
            $stmt->execute();
        }

        echo "<script>alert('Profile updated successfully!'); window.location.href='players.php';</script>";
        exit();
    }


    // DELETE ACCOUNT
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        
        $stmt1 = $conn->prepare("DELETE FROM game_registrations WHERE player_name = ?");
        $stmt1->bind_param("s", $current_user);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt2->bind_param("s", $current_user);
        $stmt2->execute();

        session_destroy();
        echo "<script>alert('Account permanently deleted.'); window.location.href='login.php';</script>";
        exit();
    }
}

$conn->close();
?>