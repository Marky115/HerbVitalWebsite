<?php
session_start();
include 'db_connect.php';

// get the herb id and displays info
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $herbId = $_GET['id'];

    $sql = "SELECT herbID, herbName, sideEffect, recommendedUsage, Benefit, imagePath
            FROM herb
            WHERE herbID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $herbId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $herb = $result->fetch_assoc();
    } else {
        // Redirect if error.
        header("Location: browseHerb.php"); 
        exit();
    }
    $stmt->close();


    // checks the user is logged in

    if (isset($_POST['save_herb'])&& isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $userId = $_SESSION['userID'];

        // Check if the herb is already saved
        $checkSql = "SELECT * FROM savedlist WHERE userID = ? AND herbID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $userId, $herbId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows == 0) {
            // Save the herb
            $insertSql = "INSERT INTO savedlist (userID, herbID) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("ii", $userId, $herbId);
            if ($insertStmt->execute()) {
                $saveMessage = "Herb saved to your list!";
            } else {
                $saveMessage = "Error saving herb.";
            }
            $insertStmt->close();
        } else {
            // or display the error message
            $saveMessage = "Herb is already in your saved list.";
        }
        $checkStmt->close();

    }
} else {
    // Redirect if invalid 
    header("Location: browseHerb.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($herb['herbName']); ?> - HerbVita</title>
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
        </div>
    </header>

    <main class="container">
        <section class="herb-details">
            <?php if ($herb): ?>
                <div class="herbPageContainer">
                    <div class="herb-image">
                        <img src="<?php echo htmlspecialchars($herb['imagePath']); ?>" alt="<?php echo htmlspecialchars($herb['herbName']); ?>">
                    </div>
                    <div class="herb-info">
                        <h2><?php echo htmlspecialchars($herb['herbName']); ?></h2>
                        <p><strong>Benefits:</strong> <?php echo nl2br(htmlspecialchars($herb['Benefit'])); ?></p>
                        <p><strong>Possible Side Effects:</strong> <?php echo nl2br(htmlspecialchars($herb['sideEffect'])); ?></p>
                        <p><strong>Recommended Usage:</strong> <?php echo nl2br(htmlspecialchars($herb['recommendedUsage'])); ?></p>

                        <!-- only displays the opetion to save if user is logged in -->

                         <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                            <form method="post">
                                <button type="submit" name="save_herb" class="saveherb">Save Herb</button>
                                <!-- maybe add a little start that changes colour when saved -->
                                <!-- click again to unsave the herb? -->
                            </form>
                            <?php if (isset($saveMessage)): ?>
                                <p class="message"><?php echo $saveMessage; ?></p>
                            <?php endif; ?>

                            <!-- if not logged in ask to login -->
                        <?php else: ?>
                            <p>You must be logged in to save herbs to your list. <a href="login.php">Login</a> or <a href="signup.php">Sign up</a>.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>Herb not found.</p>
            <?php endif; ?>
        </section>

        <!-- _____________________________________Comment Section_______________________________________- -->
        
    <section class="herb-details-comments">
        <h2>Comments</h2>
        
        <?php
      
        $sql_comments = "SELECT c.`commentText`, u.`Name` 
                        FROM `comment` c 
                        JOIN `user` u ON c.`userID` = u.`userID` 
                        WHERE c.`herbID` = ?";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param("i", $herbId);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();

        if ($result_comments->num_rows > 0) {
            echo "<div class='comments-list'>";
            while ($row = $result_comments->fetch_assoc()) {
                echo "<div class='comment-box'>";
                echo "<p><strong>" . htmlspecialchars($row['Name']) . ":</strong></p>";
                echo "<p>" . htmlspecialchars($row['commentText']) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No comments yet. Be the first to comment!</p>";
        }
        $stmt_comments->close();
        ?>
        
        
    </section>
    
    <!-- Comment Form -->
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <form action="submitComment.php" method="POST">
            <textarea name="comment" rows="5" cols="50" required></textarea>
            <input type="hidden" name="herb_id" value="<?php echo htmlspecialchars($herbId); ?>">
            <button type="submit">Post Comment</button>
        </form>
    <?php else: ?>
        <p>You must be logged in to comment. <a href="login.php">Login</a> or <a href="signup.php">Sign up</a>.</p>
    <?php endif; ?>
    
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 HerbVita. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
