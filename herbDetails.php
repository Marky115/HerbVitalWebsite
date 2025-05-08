<?php
include 'db_connect.php';
session_start();


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

    // Check if herb is already saved
    $isHerbSaved = false;

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $userId = $_SESSION['userID'];

        $checkSql = "SELECT * FROM savedlist WHERE userID = ? AND herbID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("si", $userId, $herbId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $isHerbSaved = true;
        }

        $checkStmt->close();

        // Handle Save / Unsave
        if (isset($_POST['save_herb']) && !$isHerbSaved) {
            $insertSql = "INSERT INTO savedlist (userID, herbID) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("si", $userId, $herbId);
            if ($insertStmt->execute()) {
                $saveMessage = "Herb saved to your list!";
                $isHerbSaved = true;
            } else {
                $saveMessage = "Error saving herb.";
            }
            $insertStmt->close();
        } elseif (isset($_POST['unsave_herb']) && $isHerbSaved) {
            $deleteSql = "DELETE FROM savedlist WHERE userID = ? AND herbID = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("si", $userId, $herbId);
            if ($deleteStmt->execute()) {
                $saveMessage = "Herb removed from your list.";
                $isHerbSaved = false;
            } else {
                $saveMessage = "Error unsaving herb.";
            }
            $deleteStmt->close();
        }
    }


    // prevents duplicate save and checks user authentication

    if (isset($_POST['save_herb'])&& isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $userId = $_SESSION['userID'];

        $checkSql = "SELECT * FROM savedlist WHERE userID = ? AND herbID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("si", $userId, $herbId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows == 0) {
            $insertSql = "INSERT INTO savedlist (userID, herbID) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("si", $userId, $herbId);
            if ($insertStmt->execute()) {
                $saveMessage = "Herb saved to your list!";
            } else {
                $saveMessage = "Error saving herb.";
            }
            $insertStmt->close();
        } else {
           
            $saveMessage = "Herb is already in your saved list.";
        }
        $checkStmt->close();
    }
} else {
  
    header("Location: browseHerb.php");
    exit();
}

$title = "Herb Details";
include 'header.php';
?>

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

                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <form method="post">
                            <?php if ($isHerbSaved): ?>
                                <button type="submit" name="unsave_herb" class="saveherb">Unsave Herb</button>
                            <?php else: ?>
                                <button type="submit" name="save_herb" class="saveherb">Save Herb</button>
                            <?php endif; ?>
                        </form>
                        <?php if (isset($saveMessage)): ?>
                            <p class="message"><?php echo $saveMessage; ?></p>
                        <?php endif; ?>
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
      
        $sql_comments = "SELECT c.`commentText`, u.`Name`, c.`timeAdded` 
                        FROM `comments` c 
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
                echo "<p><strong>" . htmlspecialchars($row['Name']) . "</strong> • " . 
                     date('F j, Y \a\t g:i a', strtotime($row['timeAdded'])) . "</p>";
                echo "<p>" . htmlspecialchars($row['commentText']) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } 

        $stmt_comments->close();
        ?>
        
        <!-- Comment Form -->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <div class="comment-form-wrapper">
            <form action="submitComment.php" method="POST">
                <textarea name="comment" rows="5" cols="50" required></textarea>
                <input type="hidden" name="herb_id" value="<?php echo htmlspecialchars($herbId); ?>">
                <button type="submit">Post Comment</button>
            </form>
        </div>
        <?php else: ?>
            <p>You must be logged in to comment. <a href="login.php">Login</a> or <a href="signup.php">Sign up</a>.</p>
        <?php endif; ?>
    </section>
    </main>

    <?php include 'footer.php';  ?>

