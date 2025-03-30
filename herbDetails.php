<?php
session_start();
include 'db_connect.php';

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
        // redirect if error
        header("Location: browseHerb.php"); 
        exit();
    }
} else {
    // redirect if error
    header("Location: browseHerb.php");
    exit();
}

$conn->close();
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
                        <li><a href="saved-list.php">Saved Herbs</a></li>
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
                <div class = "herbPageContainer">
                <div class="herb-image">
                    <img src="<?php echo htmlspecialchars($herb['imagePath']); ?>" alt="<?php echo htmlspecialchars($herb['herbName']); ?>">
                </div>
                <div class="herb-info">
                    <h2><?php echo htmlspecialchars($herb['herbName']); ?></h2>
                    <p><strong>Benefits:</strong> <?php echo nl2br(htmlspecialchars($herb['Benefit'])); ?></p>
                    <p><strong>Possible Side Effects:</strong> <?php echo nl2br(htmlspecialchars($herb['sideEffect'])); ?></p>
                    <p><strong>Recommended Usage:</strong> <?php echo nl2br(htmlspecialchars($herb['recommendedUsage'])); ?></p>
                </div>

            </div>

            <?php else: ?>
                <p>Herb not found.</p>
            <?php endif; ?>
        </section>

        <section class="herb-details-comments">
            <h2>Comments</h2>

        </section>


    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 HerbVita. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>