<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/scss/compiled-variables.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>event-info</title>
</head>
<body>
<?php 
if ($_SESSION["connexion"] == true) {

    if (
        !isset($_GET["id"]) || $_GET["id"] == null || 
        !isset($_GET["type"]) || $_GET["type"] == null || 
        !isset($_GET["feedback"]) || $_GET["feedback"] == null) {
            header("Location: ../index.php");
            exit;
    }

    $eventId = $_GET["id"];
    $voteType = $_GET["type"];
    $feedback = $_GET["feedback"];

    $servername = 'localhost';
    $username = 'root';
    $password = 'root';
    $db = 'event_feedback';

    // Create connection
    $connection = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }

    // Query
    $dbColumnName = "{$voteType}Votes";
    switch ($feedback) {
        case "green": $dbColumnName .= "Green";
            break;
        case "yellow": $dbColumnName .= "Yellow";
            break;
        case "red": $dbColumnName .= "Red";
            break;
    }
    $incrementVoteQuery = "UPDATE events SET {$dbColumnName} = {$dbColumnName} + 1 WHERE id={$eventId}";
    
    if ($connection->query($incrementVoteQuery) === TRUE) {
        // Marché voting.php?type=student&id=<?php echo $eventId 
        header("Location: voting.php?type=" . $voteType . "&id=" . $eventId);
        exit;
    }
    else {
        echo "Error deleting record: " . $connection->error;
    }
    $connection->close();

?>

<div class="container-fluid h-100 bg-success">
</div>

<?php 
}
else {
    header("Location: login.php");
    exit;
}
?>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
