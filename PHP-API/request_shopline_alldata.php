<?php
// Assuming you have a MySQL database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "API_DATA";
$servername = "5.189.133.78";
$username = "tigeradmin";
$password = "admintiger2023";
$dbname = "API_DATA";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the "shopline1" table
$sql = "SELECT * FROM shopline1";  // Adjust the query based on your table structure

$result = $conn->query($sql);

// Initialize an array to store the results
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Encode the data as JSON and send the response
echo json_encode($data);

// Close the database connection
$conn->close();
?>
