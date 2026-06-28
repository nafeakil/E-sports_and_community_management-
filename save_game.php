<?php
session_start();
if(!isset($_SESSION['logged_in'])) { header("Location: login.html"); exit; }

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "games_showcase";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['player_name'])) {
    $player = $_POST['player_name'];
    $game   = $_POST['game_select'];

    $stmt = $conn->prepare("INSERT INTO registered_games (player_name, selected_game) VALUES (?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("ss", $player, $game);
        
        if (!$stmt->execute()) {
            die("DATABASE REJECTED THE SAVE: " . $stmt->error);
        }

        $stmt->close();
        
        echo "<script>alert('Success! Game saved to database.'); window.location.href='register-game.html';</script>";
        exit();
    } else {
        die("SQL PREPARE FAILED: " . $conn->error);
    }
}
$conn->close();
?>