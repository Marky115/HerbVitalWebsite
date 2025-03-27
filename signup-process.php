<?php
session_start();
require('db_connect.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $userID = trim($_POST['userID']);
    $Name = trim($_POST['Name']);
    $Email = trim($_POST['Email']);
    $passwordHash = $_POST['passwordHash'];
    $healthInterest = trim($_POST['healthInterest']);

    // Validate inputs
    $errors = [];

    // Validate User ID
    if (empty($userID) || !preg_match("/^[a-zA-Z0-9]{3,11}$/", $userID)) {
        $errors[] = "Invalid User ID. Must be 3-11 characters, letters and numbers only.";
    }

    // Validate Name
    if (empty($Name) || strlen($Name) > 20) {
        $errors[] = "Invalid Name. Must be 1-20 characters.";
    }

    // Validate Email
    if (empty($Email) || !filter_var($Email, FILTER_VALIDATE_Email) || strlen($Email) > 50) {
        $errors[] = "Invalid Email Address.";
    }

    // Validate passwordHash
    if (empty($passwordHash) || strlen($passwordHash) < 8) {
        $errors[] = "passwordHash must be at least 8 characters long.";
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

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the passwordHash
        $passwordHashHash = passwordHash_hash($passwordHash, passwordHash_DEFAULT);

        // Prepare SQL to insert new user
        $stmt = $conn->prepare("INSERT INTO user (userID, Name, Email, passwordHashHash, healthInterest) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $userID, $Name, $Email, $passwordHashHash, $healthInterest);

        try {
            // Execute the statement
            if ($stmt->execute()) {
                // Registration successful
                $_SESSION['signup_success'] = "Account created successfully. Please log in.";
                header("Location: login.php");
                exit();
            } else {
                throw new Exception("Registration failed");
            }
        } catch (Exception $e) {
            $errors[] = "Registration failed. Please try again.";
        }

        $stmt->close();
    }

    // If there are errors, store them in session and redirect back to signup
    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode("<br>", $errors);
        header("Location: signup.php");
        exit();
    }
}

// Close database connection
$conn->close();
?>