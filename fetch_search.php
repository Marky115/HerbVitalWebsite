<?php
include 'db_connect.php';

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = $mysqli->real_escape_string($_GET['query']);

    $query = "SELECT herbName FROM herb WHERE herbName LIKE '%" . $searchQuery . "%' LIMIT 5"; // Limit the number of suggestions
    $result = $mysqli->query($query);

    $suggestions = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = $row['herbName'];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($suggestions);
}
?>