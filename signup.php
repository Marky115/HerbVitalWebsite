<?php
include ('signup-process.php');
include 'db_connect.php'; // Include your database connection


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
<body class='sign-up-body'>
    <div class="container2">
      
        <div class="signupContent">
            <div class='left-side'>
                <img src="./img/signupBG.jpg" alt='herb'> 
            </div>
            <div class='right-side'>
                <h2>Welcome to HerbVita</h2>


                <?php
                // Display signup error messages
                if (isset($_SESSION['signup_error'])) {
                    echo '<div class="error-message">' . htmlspecialchars($_SESSION['signup_error']) . '</div>';
                    unset($_SESSION['signup_error']);
                }
                ?>

                <form action="signup-process.php" method="POST">
                <div class='form-group'>
                    <label for="userID">User ID:</label>
                    <input type="text" id="userID" name="userID"  required>
                </div>

                <div class='form-group'>
                    <label for="Name">Name:</label>
                    <input type="text" id="Name" name="Name"  maxlength="20" required>
                </div>

                <div class='form-group'>
                    <label for="Email">Email:</label>
                    <input type="email" id="Email" name="Email"  required>
                </div>

                <div class='form-group'>
                    <label for="passwordHash">Password:</label>
                    <input type="password" id="passwordHash" name="passwordHash"  required>
                </div>

                <div class='form-group'>
                    <label for="healthInterest">Health Interests:</label>
                    <select id="healthInterest" name="healthInterest[]" multiple required size="5">
                        <?php foreach ($healthConcerns as $concernId => $concernName): ?>
                        <option value="<?php echo $concernId; ?>"><?php echo $concernName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const select = document.getElementById("healthInterest");

                        select.addEventListener("mousedown", function(e) {
                            e.preventDefault();
                            let option = e.target;
                            if (option.tagName === "OPTION") {
                                option.selected = !option.selected;
                            }
                        });
                    });
                </script>

                <button type="submit" class='btn'>Sign Up</button>
                </form>

                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
           
        </div>
    </div>
</body>
</html>