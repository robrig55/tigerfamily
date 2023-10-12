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

    //Assuming you have a MySQL database connection
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

    // Insert data into the "shopline1" table
    $shoplineCustomerId = $data['shopline_customer_id'];
    $value = $data['value'];
    $remarks = $data['remarks'];
    $expiresAt = $data['expires_at'];
    $emailTarget = $data['email_target'];
    $smsNotificationTarget = $data['sms_notification_target'];
    $relatedOrder = $data['related_order'];
    // $creditBalance = $data['credit_balance'];

    $sql = "INSERT INTO shopline1 (shopline_customer_id, value, remarks, expires_at, email_target, sms_notification_target,related_order)
            VALUES ('$shoplineCustomerId', '$value', '$remarks', '$expiresAt', '$emailTarget', '$smsNotificationTarget', '$relatedOrder')";

    if ($conn->query($sql) === TRUE) {
        http_response_code(201); // Created
        echo json_encode(['message' => 'Data push to API successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error: ' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
    exit();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method or content type']);
}
?>
