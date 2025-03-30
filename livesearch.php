<?php

include 'db_connect.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!$conn) { 
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the search query from the URL
$q = $_GET["q"];

$hint = "";

if (strlen($q) > 0) {
    $q = $conn->real_escape_string($q); 
    // $query = "SELECT herbName FROM herb WHERE herbName LIKE '%" . $q . "%' LIMIT 5"; // Limit to a reasonable number of suggestions
    $query = "SELECT herbID, herbName FROM herb WHERE LOWER(herbName) LIKE LOWER('" . $q . "%') GROUP BY herbName ORDER BY herbName LIMIT 5";
    
    $result = $conn->query($query); 

    if ($result->num_rows > 0) {

        
        while ($row = $result->fetch_assoc()) {

            if ($hint === "") {
                $hint = "<div onclick='goToHerbPage(\"" . $row['herbID'] . "\")'>" . htmlspecialchars($row['herbName']) . "</div>";
            } else {
                $hint .= "<br /><div onclick='goToHerbPage(\"" . $row['herbID'] . "\")'>" . htmlspecialchars($row['herbName']) . "</div>";
            }
        }
    }
}

// Set output to "no suggestion" if no hint was found
if ($hint === "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

echo $response;

if (isset($conn)) { 
    $conn->close();
}
?>