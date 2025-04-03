<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Validate the POST request has the required fields and comment is not empty
    if (isset($_POST['comment'], $_POST['herb_id']) && !empty(trim($_POST['comment']))) {
        // Get the user ID from session
        $userId = $_SESSION['userID'];  
        $herbId = (int) $_POST['herb_id']; 
        $comment = trim($_POST['comment']);

        // Prepares the SQL to insert the comment - using exact column names from your database
        $sql = "INSERT INTO `comment` (herbID, userID, commentText) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
       
        $stmt->bind_param("iss", $herbId, $userId, $comment);

        if ($stmt->execute()) {
            // On success, redirect back to the herb details page
            header("Location: herbDetails.php?id=" . $herbId);
            exit();
        } else {
            echo "Error posting comment: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid input.";
    }
} else {
    echo "You must be logged in to post comments.";
}

$conn->close();
?>