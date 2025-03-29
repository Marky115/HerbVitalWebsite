
<?php
session_start();
include 'db_connect.php';
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

            <section id="user-section" class="hidden">
            <h2>Welcome, User!</h2>
            <div class="user-options">
                <a href="saved-list.php">Saved Herbs</a>
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </section>

        </div>
    </header>

    <main class="container">
        

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs...">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- <section id="health-concerns">
            <h2>Explore by Health Concern</h2>
            <div class="concern-list">
                <a href="">Digestion</a>
                <a href="">Immune Support</a>
            </div>
        </section> -->

        <?php
        // Include database connection
        include 'db_connect.php';

        // Query to fetch concern
        $sql = "SELECT concernID, concernName FROM healthconcerns";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            // Output data of each row
            echo '<section id="health-concerns-db">';
            echo '<h2>Explore by Health Concern</h2>';
            echo '<div class="concern-list">';

            while ($row = $result->fetch_assoc()) {
                
    
                // need to fix
                echo '<a href="#" healthConcern="' . $row['concernID'] . '">' . $row['concernName'] . '</a>';
                
            }

            echo '</div>';
            echo '</section>';
        } else {
            echo '<p>No health concerns found.</p>';
        }

        $sql = "SELECT herbID, herbName, Benefit, imagePath FROM herb";

        $result = $conn->query($sql);


        if ($result->num_rows > 0) {



            echo '<section id="featured-herbs-db">'; // Unique ID
            echo '<h2>All Herbs</h2>';
            echo '<div class="herb-grid">';

            while ($row = $result->fetch_assoc()) {
                $imagePath = htmlspecialchars($row['imagePath']);

                echo '<div class="herb-item">';
                echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['herbName']) . '">';
                echo '<h3>' . $row['herbName'] . '</h3>';
                echo '<p>' . substr($row['Benefit'], 0, 100) . '...</p>';
                echo '<a href="herbDetails.php?id=' . $row['herbID'] . '">View Details</a>';
                echo '</div>';
            }

            echo '</div>';
            echo '</section>';
        } else {
            echo '<p>No herbs found.</p>';
        }

        $conn->close();
        ?>


    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 HerbVita. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>