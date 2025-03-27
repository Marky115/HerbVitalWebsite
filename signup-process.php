<?php
session_start();
require('db_connect.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $userID = isset($_POST['userID']) ? trim($_POST['userID']) : '';
    $Name = isset($_POST['Name']) ? trim($_POST['Name']) : '';
    $Email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $passwordHash = isset($_POST['passwordHash']) ? $_POST['passwordHash'] : '';
    
  
   $healthInterest = isset($_POST['healthInterest']) ? trim($_POST['healthInterest']) : '';

    // Collect errors
    $errors = [];

    if (empty($userID) || !preg_match("/^[a-zA-Z0-9]+$/", $userID)) {
        $errors[] = "Invalid User ID. Must contain only letters and numbers.";
    }

    
    if (empty($Name) || strlen($Name) > 20) {
        $errors[] = "Name must be 1-20 characters long.";
    }

    if (empty($Email) || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address.";
    }
    
   
    if (empty($passwordHash)) {
        $errors[] = "Password cannot be empty.";
    }
    
    // Check if userID already exists
    $check_stmt = $conn->prepare("SELECT userID FROM user WHERE userID = ?");
    $check_stmt->bind_param("s", $userID);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows > 0) {
        $errors[] = "User ID already exists. Please choose another.";
    }
    $check_stmt->close();

    // Check if Email already exists
    $check_Email_stmt = $conn->prepare("SELECT Email FROM user WHERE Email = ?");
    $check_Email_stmt->bind_param("s", $Email);
    $check_Email_stmt->execute();
    $check_Email_result = $check_Email_stmt->get_result();
    if ($check_Email_result->num_rows > 0) {
        $errors[] = "Email already registered. Please use a different Email.";
    }
    $check_Email_stmt->close();

    // Proceed only if there are no errors
    if (empty($errors)) {
        // Hash the password using PHP's password_hash function with the constant PASSWORD_DEFAULT
        $passwordHash = password_hash($passwordHash, PASSWORD_DEFAULT);

        // Prepare SQL to insert new user
        $stmt = $conn->prepare("INSERT INTO user (userID, Name, Email, passwordHash, healthInterest) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $userID, $Name, $Email, $passwordHash, $healthInterest);

        try {
            // Attempt to execute the statement
            if ($stmt->execute()) {
                // Registration successful; store success message and forward to login page
                $_SESSION['signup_success'] = "Account created successfully. Please log in.";
                header("Location: login.php");
                exit();
            } else {
                // If execution fails, throw an exception with the error from the statement
                throw new Exception("Registration failed: " . $stmt->error);
            }
        } catch (Exception $e) {
            $errors[] = "Registration failed. Please try again. " . $e->getMessage();
        }

        $stmt->close();
    }

    // If there are any errors, save them to the session and redirect back to the signup page
    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode("<br>", $errors);
        header("Location: signup.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
