
<?php
include 'db_connect.php';
session_start();


$title = "Browse Herbs";
include 'header.php';
?>


    <main class="container">
        <section id ="search-results">
        

        </section>
        

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs..." size="30" onkeyup="showResultMain(this.value)">
                <span class="search-icon"></span>
                <div id="livesearch-main"></div>
            </form>
        </div>


        <?php

        $sql = "SELECT concernID, concernName FROM healthconcerns";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            // Output data of each row
            echo '<section id="health-concerns-db">';
            echo '<h2>Explore by Health Concern</h2>';
            echo '<div class="concern-list">';

            while ($row = $result->fetch_assoc()) {
                // need to fix
                echo '<a href="#" class="filter-by-concern" data-concern-id="' . $row['concernID'] . '">' . $row['concernName'] . '</a>';
                
            }
            echo '</div>';
            echo '</section>';
        } else {
            echo '<p>No health concerns found.</p>';
        }

        $sql = "SELECT herbID, herbName, Benefit, imagePath
        FROM herb

        -- for our database, we have multiple herb id for the same herb because one herb can target differnt health aspects, when we use group by herbName it won't show duplicates
        GROUP BY herbName";


        $result = $conn->query($sql);


        if ($result->num_rows > 0) {

            echo '<section id="featured-herbs-db">'; 
            echo '<h2>All Herbs</h2>';
            echo '<div class="herb-grid">';

            while ($row = $result->fetch_assoc()) {
                $imagePath = htmlspecialchars($row['imagePath']);
                $herbDetailsLink = 'herbDetails.php?id=' . $row['herbID'];
        
                echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['herbName']) . '">';
                echo '<h3>' . $row['herbName'] . '</h3>';
                echo '<p>' . substr($row['Benefit'], 0, 100) . '.</p>';
                // Remove the separate "View Details" link
                echo '</div>';
            }
            echo '</div>';
            
        } else {
            echo '<p>No herbs found.</p>';
        }

        $conn->close();
        ?>


    </main>

    <?php include 'footer.php';  ?>