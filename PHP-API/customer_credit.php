<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

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

// Check if a shopline_customer_id was provided for search
$search_shopline_customer_id = isset($_GET['shopline_customer_id']) ? $_GET['shopline_customer_id'] : '';

// Retrieve data based on the search shopline_customer_id
$sql = "SELECT * FROM shopeline_view WHERE shopline_customer_id = '$search_shopline_customer_id'";  // Adjust the query based on your table structure
$result = $conn->query($sql);

// Initialize an empty array to store the results
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View POS Data by shopline_customer_id</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Customer Credit Management</h1>
        </div>
        <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
        <a href="dashboard.php" class="menu">Home</a>
        <a href="uploadpos.php" class="menu">Upload POS</a>
        <a href="view_pos_data.php" class="menu">View POS Data</a>
        <a href="view_shopline_data.php" class="menu">View Shopline Data</a>
        <a href="customer_credit.php" class="menu">Customer Credit Management</a>
        <a href="logout.php" class="menu">Logout</a>

        <!-- Search form -->

        <form action="" method="GET">
        <label for="shopline_customer_id">Search Shopline Customer Id:</label>
        <input type="text" id="shopline_customer_id" name="shopline_customer_id" value="<?php echo $search_shopline_customer_id; ?>">
        <button type="submit">Search</button>
        </form>

        <label for="number">Enter a number:</label>
        <input type="number" id="number">
        <button onclick="calculate()">Calculate 5%</button>
        <p id="result"></p>

    <script>
        function calculate() {
            const number = document.getElementById('number').value;
            const result = number * 0.05; // 5% calculation
            document.getElementById('result').innerText = 'Result: ' + result;

            // Set the result in a hidden input for submission
            document.getElementById('calculated_result').value = result;

            // Send the result to the PHP script for database insertion using AJAX
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log('Result inserted successfully.');
                    } else {
                        console.error('Error inserting result:', xhr.responseText);
                    }
                }
            };

            xhr.open('POST', 'insert_result.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('calculated_result=' + encodeURIComponent(result));
        }
    </script>


        <table>
            <thead>
                <tr>
                    <th>Customer Id</th>
                    <th>Remarks </th>
                    <th>Expires</th>
                    <th>Email Target </th>
                    <th>SMS Notif Target</th>
                    <th>Related Order</th>
                    <th>Amount</th>
                    <th>Remaining Amount</th>
                    <th>Value</th>
                    <th>Credit Balance</th>
                    <th>Total Credit Balance</th>
                    <!-- Add your table headers based on your table structure -->
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>";
                        echo "<td>" . $row["shopline_customer_id"] . "</td>";
                        echo "<td>" . $row["remarks"] . "</td>";
                        echo "<td>" . $row["expires_at"] . "</td>";
                        echo "<td>" . $row["email_target"] . "</td>";
                        echo "<td>" . $row["sms_notification_target"] . "</td>";
                        echo "<td>" . $row["related_order"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        echo "<td>" . $row["remaining_amount"] . "</td>";
                        echo "<td>" . $row["value"] . "</td>";
                        echo "<td>" . $row["credit_balance"] . "</td>";
                        echo "<td>" . $row["total_credit"] . "</td>";
                    // Add your table cells based on your table structure
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
