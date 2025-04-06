<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        // Dynamically set the title if a $title variable is defined on the page
        if (isset($title)) {
            echo htmlspecialchars($title) . " - HerbVita";
        } else {
            echo "HerbVita - Medicinal Herbal Web App";
        }
    ?></title>
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
                    <input type="text" name="query" size="30" onkeyup="showResult(this.value)">
                    <span class="search-icon"></span>
                    <div id="livesearch"></div>
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
