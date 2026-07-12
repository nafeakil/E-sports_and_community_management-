<?php
session_start();

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "games_showcase";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST['new_username'];
    $pass_input = $_POST['new_password'];
    $pass_confirm = $_POST['confirm_password'];

    // Check if passwords match
    if ($pass_input !== $pass_confirm) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='register.php';</script>";
        exit();
    }

    // Check if the username already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $user_input);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // The username is taken
        echo "<script>alert('That username is already taken. Please choose another one.'); window.location.href='register.php';</script>";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    $insert_stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    if ($insert_stmt) {
        $insert_stmt->bind_param("ss", $user_input, $pass_input);
        
        if ($insert_stmt->execute()) {
            // Success! Send them to the login page
            echo "<script>alert('Account created successfully! You can now log in.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('An error occurred while creating your account.'); window.location.href='register.php';</script>";
        }
        $insert_stmt->close();
    } else {
        die("SQL PREPARE FAILED: " . $conn->error);
    }
}

$conn->close();
?>