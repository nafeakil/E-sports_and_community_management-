<?php
session_start();

// Security check
if(!isset($_SESSION['logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "games_showcase";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $action = $_POST['action'];
    $reg_id = $_POST['registration_id'];
    
    // Safety check: ensure they belong to the active user
    $player_name = $_SESSION['active_user'];

    if ($action == "change") {
        $new_game = $_POST['new_game'];
        
        $stmt = $conn->prepare("UPDATE game_registrations SET selected_game = ? WHERE id = ? AND player_name = ?");
        $stmt->bind_param("sis", $new_game, $reg_id, $player_name);
        $stmt->execute();
        $stmt->close();
        
    } elseif ($action == "unregister") {
        
        $stmt = $conn->prepare("DELETE FROM game_registrations WHERE id = ? AND player_name = ?");
        $stmt->bind_param("is", $reg_id, $player_name);
        $stmt->execute();
        $stmt->close();
        
    }

    $conn->close();
    
    // Redirect back to the profile page
    header("Location: players.php");
    exit;
}
?>