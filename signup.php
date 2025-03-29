<?php
include ('signup-process.php');
include 'db_connect.php'; // Include your database connection

// Fetch health concerns from the database
$sql = "SELECT concernID, concernName FROM healthconcerns";
$result = $conn->query($sql);
$healthConcerns = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $healthConcerns[$row['concernID']] = $row['concernName'];
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - HerbVita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container1">
      
        <div class="signupContent">
            <h2>Sign Up</h2>

            <?php
            // Display signup error messages
            if (isset($_SESSION['signup_error'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['signup_error']) . '</div>';
                unset($_SESSION['signup_error']);
            }
            ?>

            <form action="signup-process.php" method="POST">
            <div>
                <label for="userID">User ID:</label>
                <input type="text" id="userID" name="userID"  required>
            </div>

            <div>
                <label for="Name">Name:</label>
                <input type="text" id="Name" name="Name"  maxlength="20" required>
            </div>

            <div>
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email"  required>
            </div>

            <div>
                <label for="passwordHash">Password:</label>
                <input type="password" id="passwordHash" name="passwordHash"  required>
            </div>

            <div>
                <label for="healthInterest">Health Interest:</label>
                <select id="healthInterest" name="healthInterest" required>
                        <option value="" disabled selected>Select a Health Concern</option>
                        <?php foreach ($healthConcerns as $concernId => $concernName): ?>
                            <option value="<?php echo $concernId; ?>"><?php echo $concernName; ?></option>
                        <?php endforeach; ?>
                    </select>
            </div>

            <button type="submit">Sign Up</button>
            </form>

            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>