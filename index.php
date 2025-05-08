
<?php
session_start();
include 'db_connect.php';


// saved featured herbs as an array so that it can loop around
// $featuredHerbs = [];

// the default nonregistered user sees different health concern category throughout the month, different one each week.
function getCurrentWeekNumber() {
    $date = new DateTime();
    $date->setISODate($date->format('Y'), $date->format('W'), 1); // Set to the first day of the week
    return $date->format('W');
}

// concern ID for the current week
function getFeaturedConcernDetails() {
    $currentWeek = getCurrentWeekNumber();
    global $conn;
    $concernDetails = null;
    $concernSql = "SELECT concernID, concernName, healthDesc FROM healthconcerns ORDER BY concernID ASC";
    $concernResult = $conn->query($concernSql);
    if ($concernResult->num_rows > 0) {
        $concerns = $concernResult->fetch_all(MYSQLI_ASSOC);
        if (!empty($concerns)) {
            // takes the current week number of the year(starting from 0) and devide by the number of concerns(8) to get the conccern to be listed this week
            $index = ($currentWeek - 1) % count($concerns);
            $concernDetails = $concerns[$index];
        }
    }
    return $concernDetails;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $userId = $_SESSION['userID'];

        $userInterestSql = "SELECT name, healthInterest FROM user WHERE userID = ?";
        $userInterestStmt = $conn->prepare($userInterestSql);
        $userInterestStmt->bind_param("s", $userId);
        $userInterestStmt->execute();
        $userInterestResult = $userInterestStmt->get_result();    

        $userHerbsByCategory = []; // Array to store herbs organized by category

    if ($userInterestRow = $userInterestResult->fetch_assoc()) {
        $userInterestString = $userInterestRow['healthInterest'];
        $userConcernIds = array_unique(array_map('trim', explode(',', $userInterestString)));

        if (!empty($userConcernIds)) {
            foreach ($userConcernIds as $concernId) {
                if (is_numeric($concernId)) {
                    // Fetch the concern name
                    $concernNameSql = "SELECT concernName FROM healthconcerns WHERE concernID = ?";
                    $concernNameStmt = $conn->prepare($concernNameSql);
                    $concernNameStmt->bind_param("i", $concernId);
                    $concernNameStmt->execute();
                    $concernNameResult = $concernNameStmt->get_result();
                    if ($concernNameRow = $concernNameResult->fetch_assoc()) {
                        $categoryName = htmlspecialchars($concernNameRow['concernName']);

                        // Fetch herbs for this specific concern
                        $relevantHerbsSql = "SELECT h.herbID, h.herbName, h.Benefit, h.imagePath
                                             FROM herb h
                                             WHERE h.healthConcerns = ?
                                             GROUP BY h.herbName
                                             ORDER BY RAND()
                                             LIMIT 3"; // Limit the number of herbs to 3 to fit the page
                        $relevantHerbsStmt = $conn->prepare($relevantHerbsSql);
                        $relevantHerbsStmt->bind_param("i", $concernId);
                        $relevantHerbsStmt->execute();
                        $relevantHerbsResult = $relevantHerbsStmt->get_result();

                        if ($relevantHerbsResult->num_rows > 0) {
                            $userHerbsByCategory[$categoryName] = $relevantHerbsResult->fetch_all(MYSQLI_ASSOC);
                        }
                        $relevantHerbsStmt->close();
                    }
                    $concernNameStmt->close();
                }
            }
        }

        if (empty($userHerbsByCategory)) {
            // If no herbs found for the user's interests, use general  weekly rotation
            $featuredConcernId = getFeaturedConcernId();
    if ($featuredConcernId !== null) {
        $concernNameSql = "SELECT concernName FROM healthconcerns WHERE concernID = ?";
        $concernNameStmt = $conn->prepare($concernNameSql);
        $concernNameStmt->bind_param("i", $featuredConcernId);
        $concernNameStmt->execute();
        $concernNameResult = $concernNameStmt->get_result();
        if ($row = $concernNameResult->fetch_assoc()) {
            $weeklyFeaturedConcernName = htmlspecialchars($row['concernName']);
        }
        $concernNameStmt->close();

        $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath
                            FROM herb
                            WHERE healthConcerns = ?
                            GROUP BY herbName
                            ORDER BY RAND()
                            LIMIT 6";
        $generalHerbsStmt = $conn->prepare($generalHerbsSql);
        $generalHerbsStmt->bind_param("i", $featuredConcernId);
        $generalHerbsStmt->execute();
        $generalHerbsResult = $generalHerbsStmt->get_result();
        if ($generalHerbsResult->num_rows > 0) {
            $featuredHerbs = $generalHerbsResult->fetch_all(MYSQLI_ASSOC);
        }
        $generalHerbsStmt->close();
    } else {
        $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath FROM herb GROUP BY herbName ORDER BY RAND() LIMIT 6";
        $generalHerbsResult = $conn->query($generalHerbsSql);
        if ($generalHerbsResult->num_rows > 0) {
            $featuredHerbs = $generalHerbsResult->fetch_all(MYSQLI_ASSOC);
        }
    }
        }
    }
    $userInterestStmt->close();
} else {
    // If the user is not logged in, fetch herbs that rotate through the concern list ID
    $featuredConcern = getFeaturedConcernDetails();
    $weeklyFeaturedConcernName = '';
    $weeklyFeaturedConcernDesc = '';
    $featuredConcernId = null;

    if ($featuredConcern !== null) {
       $weeklyFeaturedConcernName = htmlspecialchars($featuredConcern['concernName']);
        $weeklyFeaturedConcernDesc = htmlspecialchars($featuredConcern['healthDesc']);
        $featuredConcernId = $featuredConcern['concernID'];

        $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath
                            FROM herb
                            -- based on health concern ID
                            WHERE healthConcerns = ?
                            GROUP BY herbName
                            ORDER BY RAND()
                            LIMIT 6";
        $generalHerbsStmt = $conn->prepare($generalHerbsSql);
        $generalHerbsStmt->bind_param("i", $featuredConcernId);
        $generalHerbsStmt->execute();
        $generalHerbsResult = $generalHerbsStmt->get_result();
        if ($generalHerbsResult->num_rows > 0) {
            $featuredHerbs = $generalHerbsResult->fetch_all(MYSQLI_ASSOC);
        }
        $generalHerbsStmt->close();
    } else {
        // select random by name if $featuredConcern = null
        $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath FROM herb GROUP BY herbName ORDER BY RAND() LIMIT 6";
        $generalHerbsResult = $conn->query($generalHerbsSql);
        if ($generalHerbsResult->num_rows > 0) {
            $featuredHerbs = $generalHerbsResult->fetch_all(MYSQLI_ASSOC);
        }
    }
}
$title = "Home";
include 'header.php';
?>


    <main class="container">

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs" size="30" onkeyup="showResultMain(this.value)">
                <span class="search-icon"></span>
                <div id="livesearch-main"></div>
            </form>
        </div>

        <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
            <section id="featured-concern-description">
                <h2>This week's focus: <?php echo $weeklyFeaturedConcernName; ?></h2>
                <?php if (!empty($weeklyFeaturedConcernDesc)): ?>
                    <p><?php echo $weeklyFeaturedConcernDesc; ?></p>
                <?php else: ?>
                    <!-- show this if there are no desc for the concern(but we have it set for all 8 concerns) -->
                    <p>Explore our selection of herbs related to this week's highlighted health concern.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>
        


    <section id="featured-herbs-db">
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <h2>Featured Herbs Just for You, <?php
                $userId = $_SESSION['userID'];
                $userNameSql = "SELECT name FROM user WHERE userID = ?";
                $userNameStmt = $conn->prepare($userNameSql);
                $userNameStmt->bind_param("s", $userId);
                $userNameStmt->execute();
                $userNameResult = $userNameStmt->get_result();
                if ($userNameRow = $userNameResult->fetch_assoc()) {
                    echo '<a href="profile.php">' . htmlspecialchars($userNameRow['name']) . '</a>';
                } else {
                    echo 'User'; //if no name found go with default User
                }
                $userNameStmt->close();
                ?>!</h2>
            <?php
            if (!empty($userHerbsByCategory)):
                foreach ($userHerbsByCategory as $category => $herbs):
                    echo '<h3>' . htmlspecialchars($category) . '</h3>';
                    echo '<div class="herb-grid">';
                    $displayedCount = 0;
                    foreach ($herbs as $herb):
                        if ($displayedCount >= 3) break; // Limit to 3 herbs per category
                        $imagePath = htmlspecialchars($herb['imagePath']);
                        $herbDetailsLink = 'herbDetails.php?id=' . $herb['herbID'];
                        echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($herb['herbName']) . '">';
                        echo '<h3>' . htmlspecialchars($herb['herbName']) . '</h3>';
                        echo '<p>' . substr(htmlspecialchars($herb['Benefit']), 0, 100) . '</p>';
                        echo '</div>';
                        $displayedCount++;
                    endforeach;
                    echo '</div>';
                endforeach;
            else:
                if (!empty($featuredHerbs)):
                    echo '<h3>General Featured Herbs</h3>';
                    echo '<div class="herb-grid">';
                    $displayedCount = 0;
                    foreach ($featuredHerbs as $herb):
                        if ($displayedCount >= 6) break;
                        $imagePath = htmlspecialchars($herb['imagePath']);
                        $herbDetailsLink = 'herbDetails.php?id=' . $herb['herbID'];
                        echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($herb['herbName']) . '">';
                        echo '<h3>' . htmlspecialchars($herb['herbName']) . '</h3>';
                        echo '<p>' . substr(htmlspecialchars($herb['Benefit']), 0, 100) . '</p>';
                        echo '</div>';
                        $displayedCount++;
                    endforeach;
                    echo '</div>';
                else:
                    echo '<p>No herbs are currently featured.</p>';
                endif;
            endif;
            ?>
        <?php else: ?>
            
            <div class="herb-grid">
                <?php
                $displayedCount = 0;
                shuffle($featuredHerbs);
                foreach ($featuredHerbs as $herb):
                    if ($displayedCount >= 6) break;
                    $imagePath = htmlspecialchars($herb['imagePath']);
                    $herbDetailsLink = 'herbDetails.php?id=' . $herb['herbID'];
                    echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($herb['herbName']) . '">';
                    echo '<h3>' . htmlspecialchars($herb['herbName']) . '</h3>';
                    echo '<p>' . substr(htmlspecialchars($herb['Benefit']), 0, 100) . '</p>';
                    echo '</div>';
                    $displayedCount++;
                endforeach;
                if (empty($featuredHerbs)):
                    echo '<p>No herbs are currently featured for this category.</p>';
                endif;
                ?>
            </div>
        <?php endif; ?>
    </section>

    </main>

    <?php include 'footer.php';  ?>