<?php
session_start();
require ('db_connect.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // confirm input
    $userID = trim($_POST['userID']);
    $passwordHash = $_POST['passwordHash'];

    // Prepare SQL thingy
    $stmt = $conn->prepare("SELECT userID, passwordHash FROM user WHERE userID = ?");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify the password
        $user = $result->fetch_assoc();
        
        if (password_verify($passwordHash, $user['passwordHash'])) {
            // Login successful
            $_SESSION['loggedin'] = true;
            $_SESSION['userID'] = $user['userID'];
            
            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            // password error
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}
?>