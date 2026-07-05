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
    $user_input = $_POST['username'];
    $pass_input = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("MySQL syntax failed: " . $conn->error);
    }

    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        if ($pass_input === $row['password']) {
            // 1. Set the session flags
            $_SESSION['logged_in'] = true;
            $_SESSION['active_user'] = $row['username'];
            
            // 2. WRITE THE LOG INTO THE DATABASE
            $log_stmt = $conn->prepare("INSERT INTO login_logs (username) VALUES (?)");
            if ($log_stmt) {
                $log_stmt->bind_param("s", $row['username']);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // 3. Send them to the homepage
            // 3. Send them to the homepage
            header("Location: home.php");
            exit();
            
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User does not exist.'); window.location.href='login.php';</script>";
    }
    $stmt->close();
}
$conn->close();
?>