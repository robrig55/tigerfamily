<?php
include('db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user1 WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;  // Store username in session
        header("Location: dashboard.php");  // Redirect to dashboard
        exit();
    } else {
        // JavaScript to show an alert for invalid credentials and redirect to login.html
        echo "<script>alert('Invalid credentials. Please try again.'); window.location.href = 'https://tigerfamily.online/';</script>";
    }
}

$conn->close();
?>
