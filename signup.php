<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - HerbVita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container1">
        <div class="signupImg">
            <img src="./img/signupImg.png" alt="signupImg">
        </div>
        <div class="signupContent">
            <h2>Sign Up</h2>

            <?php
            // Display signup error messages
            if (isset($_SESSION['signup_error'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['signup_error']) . '</div>';
                unset($_SESSION['signup_error']);
            }
            ?>

            <form action="signup-process.php" method="post">
                <label for="userID">User ID:</label>
                <input type="text" id="userID" name="userID" required 
                       pattern="[a-zA-Z0-9]+" 
                       minlength="3" 
                       maxlength="11" 
                       title="3-11 characters, letters and numbers only"><br><br>

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required 
                       maxlength="20"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required 
                       maxlength="50"><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required 
                       minlength="8" 
                       title="Minimum 8 characters"><br><br>

                <label for="healthInterest">Health Interests:</label>
                <textarea id="healthInterest" name="healthInterest" rows="4" cols="50"></textarea><br><br>

                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>