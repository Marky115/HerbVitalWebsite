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
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HerbVita - Medicinal Herbal Web App</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>HerbVita</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li> 
                    <li><a href="browseHerb.php">Browse Herbs</a></li>
                    
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="profile.php">Saved Herbs</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login/Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div id="search-bar-header">
                <form action="search.php" method="get">
                    <input type="text" name="query" placeholder="Search Herbs...">
                    <button type="submit">Search</button>
                </form>
            </div>

        </div>
    </header>

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
            } else {
                echo "<p>Please log in to see your saved herbs. <a href='login.php'>Login</a></p>";
            }
            ?>





    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 HerbVita. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>