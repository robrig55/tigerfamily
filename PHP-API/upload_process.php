<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // File upload successful, proceed to read and insert data into the database

        // $target_dir = "/var/www/html/uploads/";
        $target_dir = "uploads";
        // Ensure the "uploads" directory exists, create it if not
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        $target_file = str_replace(" ", "_", $target_file); // Replace spaces with underscores
        $target_file = str_replace("\\", "/", $target_file); // Replace backslashes with forward slashes


        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Read the CSV file and prepare SQL insert statements
            $csvData = array_map('str_getcsv', file($target_file));

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


            foreach ($csvData as $row) {
                $pid = $row[0];  // Assuming $row[0] is the primary key
            
                // Check if the record already exists
                $checkSql = "SELECT pid FROM pos1 WHERE pid = ?";
                $checkStmt = $conn->prepare($checkSql);
                $checkStmt->bind_param("s", $shopline_customer_id);
                $checkStmt->execute();
                $checkStmt->store_result();
            
                if ($checkStmt->num_rows > 0) {
                    // Record already exists, you can choose to skip or handle accordingly
                    // echo "Record with PID $pid already exists. Skipping insertion.<br>";
                    echo "<script>alert('Record with customer id $pid already exists. Skipping insertion.'); window.location.href = 'uploadpos.php';</script>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO pos1
                                            (pid, shopline_customer_id, transaction_date, transaction_time, cashier_machine_code, 
                                            sales_order_number, item_code, item_name, unit_price, discount, registration_discount, 
                                            price_incl_tax, quantity, price, amount, remarks, reason, expires_at, email_target) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    $stmt->bind_param("sssssssssssssssssss", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], 
                                      $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18]);
                
                    if ($stmt->execute()) {
                        // echo "<script>alert('Data inserted successfully for PID $pid.');window.location.href = 'uploadpos.php';</script>";
                        echo "<script>alert('Data has been successfully inserted into the database.');window.location.href = 'uploadpos.php';</script>";
                    } else {
                        echo "Error: " . $stmt->error . "<br>";
                    }
                    
                    // Close the prepared statement
                    $stmt->close();
                }
                }
            
                // Close the check statement
                $checkStmt->close();
            
            

                // // Close the database connection
                // $conn->close();

                // echo "Data has been successfully inserted into the database.";
            }   else {
            echo "Sorry, there was an error inserting your file in the database.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
