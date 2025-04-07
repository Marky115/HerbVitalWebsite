<?php
include ('login-process.php');
$title = "Log In";
include 'header.php';
?>

<body class='login-body'>
    <div class="container1">
        <div class="loginImg">
            <img src="./img/login.jpg" alt="loginImg">
        </div>
        <div class="loginContent">
            <div class="login-card">
                <h2>Hello, Welcome Back</h2>

                <?php
                if (isset($_SESSION['signup_success'])) {
                    echo '<div class="success-message">' . htmlspecialchars($_SESSION['signup_success']) . '</div>';
                    unset($_SESSION['signup_success']);
                }

                if (isset($_SESSION['login_error'])) {
                    echo '<div class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</div>';
                    unset($_SESSION['login_error']);
                }
                ?>

                <form action="login-process.php" method="post" class='loginForm'>
                    <label for="userID">User ID:</label>
                    <input type="text" id="userID" name="userID" required>
        
                    <label for="passwordHash">Password:</label>
                    <input type="password" id="passwordHash" name="passwordHash" required>
        
                    <button type="submit" class='loginBtn'>Login</button>
                    
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </form>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>
</body>