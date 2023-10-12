<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload POS Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Upload POS Data</h1>
        </div>
        <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
        <a href="dashboard.php" class="menu">Home</a>
        <a href="uploadpos.php" class="menu">Upload POS</a>
        <a href="view_pos_data.php" class="menu">View POS Data</a>
        <a href="view_shopline_data.php" class="menu">View Shopline Data</a>
        <a href="customer_credit.php" class="menu">Customer Credit Management</a>
        <a href="logout.php" class="menu">Logout</a>
        
        <form action="upload_process.php" method="post" enctype="multipart/form-data">
            <label for="file">Select POS Data File:</label>
            <input type="file" name="file" id="file" accept=".csv">
            <br><br>
            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>
