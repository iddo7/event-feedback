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
    <title>Event Feedback</title>
</head>
<?php 
if ($_SESSION["connexion"] == true) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $db = "event_feedback";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $connection->query('SET NAMES utf8');

    $selectAllQuery = "SELECT * FROM events";
    $result = $connection->query($selectAllQuery);
    if ($result->num_rows <= 0) {
        echo "0 results";
    }
?>
<body>
    <div class="container">  
        <?php while($row = $result->fetch_assoc()) { ?>
            <div class="event-card card">
                <a href="event-info.php?id=<?php echo $row["id"] ?>">
                    <div class="row">
                        <div class="col-3">
                            <img class="event-card-img img-fluid" src="<?php echo $row["img"] ?>">
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div>
                                <h3 class="event-card-title"><?php echo $row["name"] ?></h3>
                                <ul class="event-card-list">
                                    <li class="event-card-item"><?php echo $row["date"] ?></li>
                                    <li class="event-card-item"><?php echo $row["departementId"] ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <a href="modify-event.php?id=<?php echo $row["id"] ?>">
                                <i class="event-action-icon fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
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