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
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
            <?php while($row = $result->fetch_assoc()) { ?>
                <div class="card">
                    <div class="row p-3">
                        <div class="col-3 event-info-img" style="background: url('<?php echo $row["img"] ?>')"></div>
                        <div class="col-7">
                            <h2 class="m-0"><?php echo $row["name"] ?></h2>
                            <p><?php echo $row["place"] ?></p>
                            <p><?php echo $row["date"] ?></p>
                        </div>
                        <div class="col-2">
                            <h1>ccc</h1>
                        </div>
                    </div>
                </div>
            <?php } ?>

            </div>
        </div>
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