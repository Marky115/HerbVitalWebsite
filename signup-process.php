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
    $healthInterests = isset($_POST['healthInterests']) ? $_POST['healthInterests'] : [];
    // Handle multiple health interests as a comma-separated string
    $healthInterestArray = isset($_POST['healthInterest']) ? $_POST['healthInterest'] : [];

    if (isset($_POST['healthInterest']) && is_array($_POST['healthInterest'])) {
        $healthInterestArray = $_POST['healthInterest']; // this is the right name
        $healthInterest = implode(',', $healthInterestArray);
    } else {
        $healthInterest = '';
    }
    


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
    
    if (!$healthInterestValid) {
        $errors[] = "Please select at least one health interest.";
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
    if ($stmt->execute()) {
        // Insert health interests into junction table
        $insert_interest_stmt = $conn->prepare("INSERT INTO user_health_interest (user_id, health_interest_id) VALUES (?, ?)");

        foreach ($healthInterestArray as $interestId) {
            $interestId = intval($interestId); // Sanitization
            $insert_interest_stmt->bind_param("si", $userID, $interestId);
            $insert_interest_stmt->execute();
        }

        $insert_interest_stmt->close();

        $_SESSION['signup_success'] = "Account created successfully. Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $errors[] = "Registration failed: " . $stmt->error;
    }

    $stmt->close();
    

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