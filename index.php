
<?php
session_start();
include 'db_connect.php';


// saved featured herbs as an array so that it can loop around
$featuredHerbs = [];

// making sure that the default nonregistered user sees different health concern category throughout the month, different one each week.
function getCurrentWeekNumber() {
    $date = new DateTime();
    $date->setISODate($date->format('Y'), $date->format('W'), 1); // Set to the first day of the week
    return $date->format('W');
}

// concern ID for the current week
function getFeaturedConcernId() {
    $currentWeek = getCurrentWeekNumber();
    // Fetch all concern IDs
    global $conn;
    $concernIds = [];
    $concernSql = "SELECT concernID FROM healthconcerns ORDER BY concernID ASC"; 
    $concernResult = $conn->query($concernSql);
    if ($concernResult->num_rows > 0) {
        while ($row = $concernResult->fetch_assoc()) {
            $concernIds[] = $row['concernID'];
        }
    }

    if (empty($concernIds)) {
        return null; // No concerns to rotate through
    }

    // Use the week number to determine the index in the concern IDs array
    $index = ($currentWeek - 1) % count($concernIds); // array starts at 0
    return $concernIds[$index];
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $userId = $_SESSION['userID'];

    $userInterestSql = "SELECT healthInterest FROM user WHERE userID = ?";
    $userInterestStmt = $conn->prepare($userInterestSql);
    $userInterestStmt->bind_param("s", $userId);
    $userInterestStmt->execute();
    $userInterestResult = $userInterestStmt->get_result();    if ($userInterestRow = $userInterestResult->fetch_assoc()) {
        $userInterestId = $userInterestRow['healthInterest'];

        // healthconcerns join table
        $relevantHerbsSql = "SELECT h.herbID, h.herbName, h.Benefit, h.imagePath
                             FROM herb h
                             JOIN healthconcerns hc ON h.healthconcerns = hc.concernID
                             WHERE hc.concernID = ?
                             GROUP BY h.herbName"; // Theres none but just in cacse avoid duplicates
        $relevantHerbsStmt = $conn->prepare($relevantHerbsSql);
        $relevantHerbsStmt->bind_param("s", $userInterestId);
        $relevantHerbsStmt->execute();
        $relevantHerbsResult = $relevantHerbsStmt->get_result();

        if ($relevantHerbsResult->num_rows > 0) {
            while ($row = $relevantHerbsResult->fetch_assoc()) {
                $featuredHerbs[] = $row;
            }
        } else {
            // If no Healthconern set by user use the general herb
            $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath FROM herb GROUP BY herbName ORDER BY RAND() LIMIT 6";
            $generalHerbsResult = $conn->query($generalHerbsSql);
            if ($generalHerbsResult->num_rows > 0) {
                while ($row = $generalHerbsResult->fetch_assoc()) {
                    $featuredHerbs[] = $row;
                }
            }
        }
        $relevantHerbsStmt->close();
    }
    $userInterestStmt->close();
} else {
    // If the user is not logged in, fetch herbs that rotatates through the concern list ID
    $generalHerbsSql = "SELECT herbID, herbName, Benefit, imagePath FROM herb GROUP BY herbName ORDER BY RAND() LIMIT 6";
    $generalHerbsResult = $conn->query($generalHerbsSql);
    if ($generalHerbsResult->num_rows > 0) {
        while ($row = $generalHerbsResult->fetch_assoc()) {
            $featuredHerbs[] = $row;
        }
    }
}
$title = "Home";
include 'header.php';
?>


    <main class="container">

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs..." size="30" onkeyup="showResultMain(this.value)">
                <span class="search-icon"></span>
                <div id="livesearch-main"></div>
            </form>
        </div>


    <section id="featured-herbs-db">
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <h2>Featured Herbs Just for You, <?php echo htmlspecialchars($_SESSION['userID']); ?>!</h2>
        <?php else: ?>
            <h2>This week's Featured Herbs category is
            <?php
            $featuredConcernId = getFeaturedConcernId();
            $weeklyFeaturedConcernName = "";
            if ($featuredConcernId !== null) {
                $concernNameSql = "SELECT concernName FROM healthconcerns WHERE concernID = ?";
                $concernNameStmt = $conn->prepare($concernNameSql);
                $concernNameStmt->bind_param("i", $featuredConcernId);
                $concernNameStmt->execute();
                $concernNameResult = $concernNameStmt->get_result();
                if ($row = $concernNameResult->fetch_assoc()) {
                    $weeklyFeaturedConcernName = $row['concernName'];
                }
                $concernNameStmt->close();
            }
            if (isset($weeklyFeaturedConcernName) && !empty($weeklyFeaturedConcernName)):
                echo htmlspecialchars($weeklyFeaturedConcernName);
            else:
                echo "being highlighted"; // Or a default message if the name isn't set
            endif;
        ?>
    </h2>
        <?php endif; ?>
        
        <div class="herb-grid">
            <?php
            // 3. Rotate the Display (Randomly select up to 6 herbs)
            shuffle($featuredHerbs);
            $displayedCount = 0;
            foreach ($featuredHerbs as $herb) {
                if ($displayedCount >= 6) break; // only display 6 herbs
                $imagePath = htmlspecialchars($herb['imagePath']);
                $herbDetailsLink = 'herbDetails.php?id=' . $herb['herbID'];
                echo '<div class="herb-item" onclick="window.location.href=\'' . $herbDetailsLink . '\'">';
                echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($herb['herbName']) . '">';
                echo '<h3>' . htmlspecialchars($herb['herbName']) . '</h3>';
                echo '<p>' . substr(htmlspecialchars($herb['Benefit']), 0, 100) . '...</p>';
                echo '</div>';
                $displayedCount++;
            }
            if (empty($featuredHerbs)) {
                echo '<p>No herbs are currently featured.</p>';
            }
            ?>


    </main>

    <?php include 'footer.php';  ?>