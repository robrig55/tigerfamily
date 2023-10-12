<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "API_DATA";
// $servername = "5.189.133.78";
// $username = "tigeradmin";
// $password = "admintiger2023";
// $dbname = "API_DATA";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Pagination parameters
$itemsPerPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;


// Retrieve data with pagination
$sql = "SELECT * FROM pos1 LIMIT $offset, $itemsPerPage";  // Adjust the query based on your table structure
$result = $conn->query($sql);

// Initialize an empty array to store the results
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Check if the request format is JSON
if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Encode the data as JSON and send the response
    echo json_encode($data);
} else {
    // HTML Table rendering
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>View POS Data</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </head>
    <body>
        
        <div class='container'>
            <div class='header'>
                <h1>View POS Data</h1>
            </div>
            <h3>Welcome, ".$_SESSION['username']."</h3>
            <a href='dashboard.php' class='menu'>Home</a>
            <a href='uploadpos.php' class='menu'>Upload POS</a>
            <a href='view_pos_data.php' class='menu'>View POS Data</a>
            <a href='view_shopline_data.php' class='menu'>View Shopline Data</a>
            <a href='customer_credit.php' class='menu'>Customer Credit Management</a>
            <a href='logout.php' class='menu'>Logout</a>
            <table>
                <thead>
                    <tr>
                    <th>Shopline Customer Id</th>
                    <th>Transaction Date</th>
                    <th>Transaction Time</th>
                    <th>Casher Machine Code</th>
                    <th>Sales Order Number</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Registration Discount</th>
                    <th>Price Incl Tax</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Reason</th>
                    <th>Expires</th>
                    <th>Email Target</th>
                    <th>Credit Balance</th>
                        <!-- Add more headers based on your table structure -->
                    </tr>
                </thead>
                <tbody>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $row["shopline_customer_id"] . "</td>";
        echo "<td>" . $row["transaction_date"] . "</td>";
        echo "<td>" . $row["transaction_time"] . "</td>";
        echo "<td>" . $row["cashier_machine_code"] . "</td>";
        echo "<td>" . $row["sales_order_number"] . "</td>";
        echo "<td>" . $row["item_code"] . "</td>";
        echo "<td>" . $row["item_name"] . "</td>";
        echo "<td>" . $row["unit_price"] . "</td>";
        echo "<td>" . $row["discount"] . "</td>";
        echo "<td>" . $row["registration_discount"] . "</td>";
        echo "<td>" . $row["price_incl_tax"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["remarks"] . "</td>";
        echo "<td>" . $row["reason"] . "</td>";
        echo "<td>" . $row["expires_at"] . "</td>";
        echo "<td>" . $row["email_target"] . "</td>";
        echo "<td>" . $row["credit_balance"] . "</td>";
        // Add more columns based on your table structure
        echo "</tr>";
    }

    echo "</tbody>
            </table>";

            // Display pagination links
            $totalRows = 100; // Assume you know the total number of rows
            $totalPages = ceil($totalRows / $itemsPerPage);
        
            echo "<div class='pagination'>";
            if ($page > 1) {
                echo "<a href='view_pos_data.php?page=".($page - 1)."'>Previous</a>";
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='view_pos_data.php?page=$i' ".($page === $i ? "class='active'" : "").">$i</a>";
            }
            if ($page < $totalPages) {
                echo "<a href='view_pos_data.php?page=".($page + 1)."'>Next</a>";
            }

            echo "</div>";
    echo "</div>
    </body>
    </html>";
}

// Close the database connection
$conn->close();
?>
