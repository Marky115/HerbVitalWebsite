
<?php

include 'db_connect.php';
session_start();

$title = "Home";
include 'header.php';
?>


    <main class="container">
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['userID']); ?>!</h2>
    <?php endif; ?>

        <div id="search-bar-main">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search Herbs..." size="30" onkeyup="showResultMain(this.value)">
                <span class="search-icon"></span>
                <div id="livesearch-main"></div>
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

    <?php include 'footer.php';  ?>