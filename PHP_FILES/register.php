<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Games Showcase</title>
  <link rel="stylesheet" href="../CSS/style2.css">
  <style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: "BBH", sans-serif;
  }

  @font-face {
    font-family: 'BBH';
    src: url('../TEMPLATES_FILE/BBHBartle-Regular.ttf');
  }
  
  body {
    background: radial-gradient(circle, #ff006a 0%, #000 100%);
    margin: 0;
    min-height: 100vh; 
  }
  
  .login-box {
    backdrop-filter: blur(10px);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px; 
    height: 420px; /* Made slightly taller to fit the extra box */
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
    color: rgb(255, 255, 255); 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px; 
    box-sizing: border-box;
    background-color: rgb(32, 32, 32); 
    background-image: url('../TEMPLATES_FILE/endfield.png');
    background-size: cover;
  }

  .login-box form {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .login-box input {
    width: 100%;
    padding: 10px;
    margin-top: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
  }

  .login-box button {
    width: 100%;
    margin-top: 25px;
    border-radius: 8px;
    padding: 10px;
    border: 1px solid #ccc;
    box-shadow: 0 0 20px rgba(0,0,0,0.8);
    cursor: pointer;
    box-sizing: border-box;
  }

  .login-box button:hover { 
    transform: translateY(-3px);
    transition: 0.4s ease;
    background-color: #ff006a; 
    color: white;
  }
  </style>
</head>
<body>

  <div class="login-box">
    <h3 style="color: white; letter-spacing: 2px; margin-bottom: 10px;">REGISTER</h3>
    
    <form action="register_check.php" method="POST">
      <input type="text" name="new_username" placeholder="Choose a Username" required autocomplete="off">
      <input type="password" name="new_password" placeholder="Create Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      
      <button type="submit">CREATE ACCOUNT</button>
      
      <p style="margin-top: 15px; font-size: 10px; color: white; text-align: center; width: 100%;">
        Already registered? 
        <a href="login.php" style="color: #ff0000; text-decoration: none; font-weight: bold;">Login here</a>
      </p>
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