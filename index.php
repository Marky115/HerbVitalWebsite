
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
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['userID']); ?>!</h2>
    <?php endif; ?>

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs...">
                <button type="submit">Search</button>
            </form>
        </div>

        <section id="featured-herbs-static">  <h2>Featured Herbs (placeholder)</h2>
            <div class="herb-grid">
                <div class="herb-item">
                    <img src="./img/peppermint.jpg" alt="peppermint">
                    <h3>Peppermint (placeholder)</h3>
                    <p>Brief description take info from sql...</p>
                    <a href="">View Details</a>
                </div>
                <div class="herb-item">
                    <img src="./img/peppermint.jpg" alt="peppermint">
                    <h3>Herb2 (placeholder)</h3>
                    <p>Brief description take info from sql...</p>
                    <a href="">View Details</a>
                </div>
                <div class="herb-item">
                    <img src="./img/peppermint.jpg" alt="peppermint">
                    <h3>Herb3 (placeholder)</h3>
                    <p>Brief description take info from sql...</p>
                    <a href="">View Details</a>
                </div>
            </div>
        </section>

        <section id="health-concerns">
            <h2>Explore by Health Concern</h2>
            <div class="concern-list">
                <a href="">Digestion</a>
                <a href="">Immune Support</a>
            </div>
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