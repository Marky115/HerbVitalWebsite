<?php
session_start();
require ('db_connect.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $userID = trim($_POST['userID']);
    $passwordHash = $_POST['passwordHash'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT userID, passwordHash FROM user WHERE userID = ?");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify passwordHash
        $user = $result->fetch_assoc();
        
        if (passwordHash_verify($passwordHash, $user['passwordHash'])) {
            // Login successful
            $_SESSION['loggedin'] = true;
            $_SESSION['userID'] = $user['userID'];
            
            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            // Invalid passwordHash
            $_SESSION['login_error'] = "Invalid username or passwordHash";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid username or passwordHash";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}
?>