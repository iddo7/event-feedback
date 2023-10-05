<?php
session_start();
?>
<?php include 'navbar.php'; ?>

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
    <div class="container-fluid p-0 mb-5">
        <div class="p-5 bg-darker">
            <div class="row">
                <div class="col-10">
                    <h1>Évènements</h1>
                </div>
                <div class="col-2 d-flex justify-content-end h-100">
                    <button class="btn btn-primary vote-btn btn-lg">
                        <a href="add-event.php">
                            <i class="fa-solid fa-calendar-plus"></i>
                            Ajouter
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">

            <?php while($row = $result->fetch_assoc()) { ?>
                <?php $eventInfoLink = "event-info.php?id=" . $row["id"] ?>
                    <div class="card shadow mb-4">
                        <div class="row m-0 p-3">
                            <a class="col-3 event-img" style="background: url('<?php echo $row["img"] ?>')" href="<?php echo $eventInfoLink ?>"></a>
                            <a class="col-7 event-card-infos" href="<?php echo $eventInfoLink ?>">
                                <h2 class=""><?php echo $row["name"] ?></h2>
                                <p><?php echo $row["place"] ?></p>
                                <p><?php echo $row["date"] ?></p>
                            </a>

                            <div class="col-2 d-inline-flex align-items-center justify-content-center">
                                <div class="row">
                                    <div class="col-4">
                                        <!-- Vote Button -->
                                        <a href="choose-vote-type.php?id=<?php echo $row["id"] ?>">
                                            <i class="event-card-action-icon fa-solid fa-check-to-slot"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <!-- Edit Button -->
                                        <a href="modify-event.php?id=<?php echo $row["id"]?>&previousPage=events">
                                            <i class="event-card-action-icon fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <!-- Delete Button 
                                        -->
                                        <a href="delete-event.php?id=<?php echo $row["id"] ?>">
                                            <i class="event-card-action-icon fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php } ?>
            </div>

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