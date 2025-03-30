<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Validate the POST request has the required fields and comment is not empty
    if (isset($_POST['comment'], $_POST['herbID']) && !empty(trim($_POST['comment']))) {
        // Use the same session variable key as set in the login process
        $userId = $_SESSION['userID'];  
        $herbID = (int) $_POST['herbID'];  // Cast to integer for safety
        $comment = htmlspecialchars(trim($_POST['comment']));

        // Prepare the SQL to insert the comment
        $sql = "INSERT INTO comments (user_id, herb_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $userId, $herbID, $comment);

        if ($stmt->execute()) {
            // On success, redirect back to the herb details page
            header("Location: herbDetails.php?id=" . $herbID);
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
