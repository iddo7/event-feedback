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
<body>
<?php 
if ($_SESSION["connexion"] == true) {

    if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {

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
    
        $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];
        $selectAllQuery = "SELECT * FROM events WHERE id=" . $eventId;
        $result = $connection->query($selectAllQuery);
        if ($result->num_rows <= 0) {
            echo "0 results";
        }
        while($row = $result->fetch_assoc()) {
            $valuesInputed = array(
                "name" => $row["name"],
                "date" => $row["date"],
                "place" => $row["place"],
                "description" => $row["description"],
                "img" => $row["img"],
                "departementId" => $row["departementId"],
                "studentVotesGreen" => $row["studentVotesGreen"],
                "studentVotesYellow" => $row["studentVotesYellow"],
                "studentVotesRed" => $row["studentVotesRed"],
                "professionalVotesGreen" => $row["professionalVotesGreen"],
                "professionalVotesYellow" => $row["professionalVotesYellow"],
                "professionalVotesRed" => $row["professionalVotesRed"],
            );
        }

        $errorOccured = false;
        $alertMessage = '';
?>
<div class="container-fluid p-0">
    <div class="p-5 bg-darker">
        <div class="row mb-3 event-info-details">
            <div class="col-4 event-img" style="background: url('<?php echo $valuesInputed["img"] ?>')"></div>
            <div class="col-8 ps-4">
                <div class="row mb-2 d-flex ajust-items-center">
                    <div class="col-8">
                        <h1 class="m-0"><?php echo $valuesInputed["name"] ?></h1>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div class="d-flex justify-content-center w-100">
                            <a href="choose-vote-type.php?id=<?php echo $eventId ?>" class="w-100">
                                <button class="btn btn-primary vote-btn w-100">Voter</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <span class="small me-3"><?php echo $valuesInputed["date"] ?></span>
                        <span class="small me-3"><?php echo $valuesInputed["place"] ?></span>
                        <span class="small me-3"><?php echo $valuesInputed["departementId"] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><?php echo $valuesInputed["description"] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>

    </div>
</div>
<div class="container-fluid">
    <div class="row p-5 d-flex justify-content-center">

        <!-- Student Votes Section -->
        <div class="card col-5 me-5 shadow">
            <div class="row p-3">
                <div class="col-12 p-0">
                    <h2 class="m-0">Étudiants</h2>
                </div>
            </div>
            <div class="row p-3 text-center">
                <div class="col-4 bg-success"><?php echo $valuesInputed["studentVotesGreen"] ?></div>
                <div class="col-4 bg-warning"><?php echo $valuesInputed["studentVotesYellow"] ?></div>
                <div class="col-4 bg-danger"><?php echo $valuesInputed["studentVotesRed"] ?></div>
            </div>
        </div>

        <!-- Professional Votes Section -->
        <div class="card col-5 shadow">
            <div class="row p-3">
                <div class="col-12 p-0">
                    <h2 class="m-0">Professionels</h2>
                </div>
            </div>
            <div class="row p-3 text-center">
                <div class="col-4 bg-success"><?php echo $valuesInputed["professionalVotesGreen"] ?></div>
                <div class="col-4 bg-warning"><?php echo $valuesInputed["professionalVotesYellow"] ?></div>
                <div class="col-4 bg-danger"><?php echo $valuesInputed["professionalVotesRed"] ?></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-2">
            <a href="modify-event.php?id=<?php echo $eventId ?>" class="w-100">
                <button class="btn btn-outline-primary vote-btn w-100">Modifier</button>
            </a>
        </div>
        <div class="col-2">
            <a href="delete-event.php?id=<?php echo $eventId ?>" class="w-100">
                <button class="btn btn-outline-danger vote-btn w-100">Supprimer</button>
            </a>
        </div>
    </div>
</div>
<?php 
}
}
else {
    header("Location: login.php");
    exit;
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
