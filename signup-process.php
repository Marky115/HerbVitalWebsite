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

     // Validate User ID (allow letters and numbers)
     if (empty($userID) || !preg_match("/^[a-zA-Z0-9]+$/", $userID)) {
        $errors[] = "Invalid User ID. Must contain only letters and numbers.";
    }

    // Validate Name (allow any characters, just check length)
    if (empty($Name) || strlen($Name) <= 20) {
        $errors[] = "Name must be 1-20 characters long.";
    }

    // Validate Email (strict email format)
    if (empty($Email) || !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address.";
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