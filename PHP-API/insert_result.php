<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "API_DATA";  
// Replace with your actual database name
// $servername = "5.189.133.78";
// $username = "tigeradmin";
// $password = "admintiger2023";
// $dbname = "API_DATA";

// Retrieve the calculated result and shopline_customer_id from the AJAX request
$calculated_result = $_POST['calculated_result'];
$shopline_customer_id = $_POST['shopline_customer_id']; // Assuming you send this from the frontend

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the credit_balance for the specific shopline_customer_id
$query = "UPDATE pos1 SET credit_balance = '$calculated_result' WHERE shopline_customer_id = '$shopline_customer_id'";

if ($conn->query($query) === TRUE) {
    echo "Credit balance updated successfully.";
} else {
    echo "Error updating credit balance: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
