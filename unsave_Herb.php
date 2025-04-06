<?php
session_start();
include 'db_connect.php';

// Make sure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to perform this action']);
    exit;
}

// Check if herbId was provided
if (!isset($_POST['herbId']) || empty($_POST['herbId'])) {
    echo json_encode(['success' => false, 'message' => 'No herb specified']);
    exit;
}

$userId = $_SESSION['userID'];
$herbId = $_POST['herbId'];

// Prepare and execute the delete query
$sql = "DELETE FROM savedlist WHERE userID = ? AND herbID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $userId, $herbId);

if ($stmt->execute()) {
    // Successfully deleted
    echo json_encode(['success' => true]);
} else {
    // Error occurred
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>