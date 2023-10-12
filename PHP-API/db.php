<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "API_DATA";

// $servername = "5.189.133.78";
// $username = "tigeradmin";
// $password = "admintiger2023";
// $dbname = "API_DATA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
