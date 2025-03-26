<?php>
session_start();

$dbhost = "localhost"; 
$dbuser = "root"; 
$dbpass = ""; 
$dbname = "probjectherb"; 


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_errno()) {
    
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

// Prepared statement for secure login
$check_user_query = "SELECT id, password FROM users WHERE username = ?";
$statement = mysqli_prepare($connection, $check_user_query);

if(!$statement) {
    die("Error preparing statement: " . mysqli_error($connection));
}

// Bind the username parameter
mysqli_stmt_bind_param($statement, 's', $_POST['username']);
mysqli_stmt_execute($statement);

// Get the result
$result = mysqli_stmt_get_result($statement);

if(mysqli_num_rows($result) > 0) {
    // User exists, check password
    $user = mysqli_fetch_assoc($result);
    
    if (password_verify($_POST['password'], $user['password'])) {
        // Successful login
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['user_id'] = $user['id'];
        
        // Redirect to home/dashboard
        header('Location: index.html');
        exit;
    } else {
        // Wrong password
        $_SESSION['login_error'] = 'Incorrect username or password';
        header('Location: login.html');
        exit;
    }
} else {
    // User doesn't exist
    $_SESSION['login_error'] = 'Incorrect username or password';
    header('Location: login.html');
    exit;
}

// Clean up
mysqli_stmt_close($statement);
mysqli_close($connection);

?>