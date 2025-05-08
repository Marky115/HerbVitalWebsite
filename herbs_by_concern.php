<?php
include 'db_connect.php';

if (isset($_POST['concern_id']) && is_numeric($_POST['concern_id'])) {
    $concernID = $conn->real_escape_string($_POST['concern_id']);

    $sql = "SELECT herbID, herbName, Benefit, imagePath
            FROM herb
            WHERE healthConcerns = $concernID
            GROUP BY herbName";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="herb-grid">';
        while ($row = $result->fetch_assoc()) {
            $imagePath = htmlspecialchars($row['imagePath']);
            $herbDetailsLink = 'herbDetails.php?id=' . $row['herbID'];
        
            echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['herbName']) . '">';
                echo '<h3>' . $row['herbName'] . '</h3>';
                echo '<p>' . substr($row['Benefit'], 0, 100) . '.</p>';
                echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No herbs found for this health concern.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}

$conn->close();
?>