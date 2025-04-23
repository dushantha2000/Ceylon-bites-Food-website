<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ck";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a session at the beginning of your script
session_start();

// Search for data in a table named "user"
$tableName = "user";

// Use mysqli_real_escape_string to prevent SQL injection
$searchTerm_1 = mysqli_real_escape_string($conn, $_POST['username']);
$searchTerm_2 = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM $tableName WHERE first_name = '$searchTerm_1' AND password = '$searchTerm_2'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Authentication successful
    // Fetch user_id from the database
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    // Store the username and user_id in the session
    $_SESSION['username'] = $searchTerm_1;
    $_SESSION['user_id'] = $user_id;

    // Close connection
    $conn->close();

    // Redirect to the desired page
    header("Location: logged.php");
    exit();
} else {
    echo "Login failed. Please check your username and password.";
}

// Close connection
$conn->close();
?>