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

        </div>
    </header>

    <main class="container">
        

        <h1>hi user</hi>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['userID']); ?>!</h2>


    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 HerbVita. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>