<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Handle JSON data
    $jsonPayload = file_get_contents('php://input');
    $data = json_decode($jsonPayload, true);

    if ($data === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit();
    }

    // Handle the POST request and insert data into the database as you've done

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET requests to retrieve data for a specific shopline_customer_id
    if (isset($_GET['shopline_customer_id'])) {
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
            http_response_code(500);
            echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
            exit();
        }

        $shoplineCustomerId = $_GET['shopline_customer_id'];

        // Retrieve data for the specified shopline_customer_id
        $sql = "SELECT * FROM shopline1 WHERE shopline_customer_id = '$shoplineCustomerId'";
        $result = $conn->query($sql);

        if ($result === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Error executing the query: ' . $conn->error]);
            $conn->close();
            exit();
        }

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            http_response_code(200);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No data found for the specified shopline_customer_id']);
        }

        // Close the database connection
        $conn->close();
        exit();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing shopline_customer_id parameter']);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method or content type']);
    exit();
}
?>
