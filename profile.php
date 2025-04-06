<?php
session_start();

include 'db_connect.php';



// join the herb table with the saved list to show the names and images as well

function getSavedHerbs($conn, $userId) {
    $sql = "SELECT h.herbID, h.herbName, h.imagePath
            FROM savedlist sli
            JOIN herb h ON sli.herbID = h.herbID
            WHERE sli.userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$title = "Profile page";
include 'header.php';


?>

    <main class="container">
        
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['userID']); ?>!</h1>

        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                $userId = $_SESSION['userID'];
                $savedHerbs = getSavedHerbs($conn, $userId);

                if (!empty($savedHerbs)) {
                    foreach ($savedHerbs as $herb) {
                        echo "<div class='saved-herb-item'>";
                        echo "<img src='" . htmlspecialchars($herb['imagePath']) . "' alt='" . htmlspecialchars($herb['herbName']) . "'>";
                        echo "<div class='saved-herb-info'>";
                        // once clicked on, takes the user to that herb's page
                        echo "<h3><a href='herbDetails.php?id=" . htmlspecialchars($herb['herbID']) . "'>" . htmlspecialchars($herb['herbName']) . "</a></h3>";
                        echo "</div>";
                        echo "<div class='saved-herb-actions'>";
                        echo "<button onclick='unsaveHerb(" . htmlspecialchars($herb['herbID']) . ")'>Unsave</button>";
                        // prob need ajax to get it to unsave and fetches
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='no-saved-herbs'>You haven't saved any herbs yet.</p>";
                }

                echo "<div class='profile-actions'>";
                echo "<h2>Account Actions</h2>";
                echo "<button class='delete-profile-btn' onclick='confirmDeleteProfile()'>Delete Profile</button>";
                echo "</div>";
                

            } else {
                echo "<p>Please log in to see your saved herbs. <a href='login.php'>Login</a></p>";
            }
            ?>





    </main>

    <?php include 'footer.php';  ?>