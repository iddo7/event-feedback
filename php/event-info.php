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

?>
<div class="container-fluid vh-100">
    <div class="row height100">
        <?php 
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
                        "description" => $row["description"],
                        "img" => $row["img"],
                        "departementId" => $row["departementId"],
                        "studentVotesGreen" => $row["studentVotesGreen"],
                        "studentVotesYellow" => $row["studentVotesYellow"],
                        "studentVotesRed" => $row["studentVotesRed"],
                    );
                }

                $errorOccured = false;
                $alertMessage = '';
        ?>
            <div class="col-md-6 height100">
                <div class="card border-0 height100">
                    <img class="card-img-top height100" src="<?php echo $valuesInputed["img"] ?>" alt="Card image cap">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="card border-0 mx-auto">
                    <div class="card-body">
                        <h1 class="card-title display-3"><?php echo $valuesInputed["name"] ?></h1>
                        <p class="card-text"><?php echo $valuesInputed["date"] ?></p>
                        <p class="card-text"><?php echo $valuesInputed["description"] ?></p>
                        <div class="row">
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>
                                <h2 class="display-5"><?php echo $valuesInputed["studentVotesGreen"] ?></h2>                                              
                            </div>
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>
                                <h2 class="display-5"><?php echo $valuesInputed["studentVotesYellow"] ?></h2>                                              
                            </div>
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>  
                                <h2 class="display-5"><?php echo $valuesInputed["studentVotesRed"] ?></h2>                      
                            </div>
                        </div>
                        <div class="d-flex justify-content-center m-5">
                            <a href="choose-vote-type.php?id=<?php echo $eventId ?>" class="btn btn-primary">Voter</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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
