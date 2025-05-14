<?php
include 'db_connect.php';
header('Content-Type: application/json'); //tells the client that the response is JSON

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['concern_id']) && is_numeric($_POST['concern_id'])) {
    $concernID = $conn->real_escape_string($_POST['concern_id']);

    $sql = "SELECT herbID, herbName, Benefit, imagePath
            FROM herb
            WHERE healthConcerns = $concernID
            GROUP BY herbName";

    $result = $conn->query($sql);
    $herbs = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $herbs[] = [
                'herbID' => (int)$row['herbID'],
                'herbName' => $row['herbName'],
                'Benefit' => $row['Benefit'],
                'imagePath' => $row['imagePath']
            ];
        }
        echo json_encode(['success' => true, 'herbs' => $herbs]); 
    } 
    else {
        echo json_encode(['success' => false, 'message' => 'No herbs found for this health concern.']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing concern ID.']);
} 

$conn->close();
?>