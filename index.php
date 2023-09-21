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
    <link rel="stylesheet" href="style/scss/compiled-variables.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Event Feedback</title>
</head>
<?php 
if ($_SESSION["connexion"] == true) {
    
    $valuesInputed = array(
        "username" => "",
        "password" => "",
    );
    $errorOccured = false;
    $alertMessage = '';


    // FORM WAS SUBMITTED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("username", "password");

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

        for ($i = 0; $i < sizeof($inputs); $i++) {
            $keys = array_keys($valuesInputed);
            $valuesInputed[$keys[$i]] = trojan($_POST[$inputs[$i]]);
        }

        if (!$errorOccured) {
            $username = $_POST['username'];
            $password = md5($_POST['password'], false);            

            $servername = "localhost";
            $usernameDB = "root";
            $passwordDB = "root";
            $db = "event_feedback";

            // Create connection
            $connection = new mysqli($servername, $usernameDB, $passwordDB, $db);
            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

        $connection->close();
        }
    }

    
    function anyIsEmpty($arrayOfInputs) {
        $result = false;
        foreach ($arrayOfInputs as $input) {
            if (empty($_POST[$input])) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    function trojan($data){
        $data = trim($data); //Enleve les caractères invisibles
        $data = addslashes($data); //Mets des backslashs devant les ' et les  "
        $data = htmlspecialchars($data); // Remplace les caractères spéciaux par leurs symboles comme ­< devient &lt;
        
        return $data;
    }
?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mt-5">
                <span class="logo">Event Feedback</span>
            </div>
        </div>
    </div>
    <div class="container-fluid screen-center-y">
        <div class="row">
            <h1 class="choose-title text-center">Accueil</h1>
            <div class="col-6 text-center">
                <a href="#">
                    <i class="choose-icon fa-solid fa-user-plus"></i>
                    <h2>Créer utilisateur</h2>
                </a>
            </div>
            <div class="col-6 text-center">
                <a href="php/events.php">
                    <i class="choose-icon fa-solid fa-calendar-days"></i>
                    <h2>Évènements</h2>
                </a>
            </div>
        </div>
    </div>
<?php 
}
else {
    header("Location: php/login.php");
    exit;
}
?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>