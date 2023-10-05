<?php session_start(); ?>
<?php include 'variables-db.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback</title>
</head>
<?php 
if ($_SESSION["connexion"] == true) {




    // Create connection
    $connection = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }

    // Query
    $deleteQuery = "DELETE FROM events WHERE id=" . $_GET["id"];

    if ($connection->query($deleteQuery) === TRUE) {
        echo "Record deleted successfully";
    }
    else {
        echo "Error deleting record: " . $connection->error;
    }
    $connection->close();

    header("Location: events.php");
    exit;
?>
<body>
</body>
<?php 
}
else {
    
    header("Location: login.php");
    exit;
    
}
?>
</html>