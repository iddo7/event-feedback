<?php
session_start();
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/scss/compiled-variables.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Event Feedback</title>
</head>

<?php 

function anyIsEmpty($arrayOfInputs) {
    $result = false;
    foreach ($arrayOfInputs as $input) {
        if ($input !== "mdp" && empty($_POST[$input])) {
            $result = true;
            break;
        }
    }
    return $result;
}

function trojan($data){
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SESSION["connexion"] == true) {

    $valuesInputed = array(
        "prenom" => "", 
        "email" => "",
        "mdp" => "",
    );
    $errorOccured = false;
    $alertMessage = '';

    $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("prenom", "email", "mdp");

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

        for ($i = 0; $i < sizeof($inputs); $i++) {
            $keys = array_keys($valuesInputed);
            $valuesInputed[$keys[$i]] = trojan($_POST[$inputs[$i]]);
        }

        // Only update the password if it's provided in the form
        if (!empty($_POST['mdp'])) {
            $valuesInputed['mdp'] = md5($_POST['mdp']);
        }

        if (!$errorOccured) {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "event_feedback";
        
            $connection = mysqli_connect($servername, $username, $password, $db);
        
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $connection->query('SET NAMES utf8');

            $prenom = $valuesInputed['prenom'];
            $email = $valuesInputed['email'];
            $mdp = $valuesInputed['mdp'];
            
            $updateQuery = "UPDATE users SET prenom='{$prenom}', email='{$email}'";
            if (!empty($_POST['mdp'])) {
                $updateQuery .= ", password='{$mdp}'";
            }
            $updateQuery .= " WHERE id={$eventId}";
            
            if ($connection->query($updateQuery) === TRUE) {
                $alertMessage = "L'ajout s'est bien produit";
                header("Location: users.php");
                exit;
            }
            else {
                $alertMessage = "Erreur updating record : " . $connection->error;
                $errorOccured = true;
            }

            mysqli_close($connection);
        }
    }
?>

<body>
    <div class="p-4 screen-center col-12 col-md-6 col-xl-4">
        <h1 class="text-center">Modifier utilisateur</h1>
        <hr>

        <?php 
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {

                $servername = "localhost";
                $username = "root";
                $password = "root";
                $db = "event_feedback";
            
                $connection = new mysqli($servername, $username, $password, $db);
            
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }
            
                $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];
                $selectAllQuery = "SELECT * FROM users WHERE id=" . $eventId;
                $result = $connection->query($selectAllQuery);
                if ($result->num_rows <= 0) {
                    echo "0 results";
                }
            
                while($row = $result->fetch_assoc()) {
                    $valuesInputed = array(
                        "prenom" => $row["prenom"],
                        "email" => $row["email"],
                        "password" => $row["password"],
                    );
                }
                $errorOccured = false;
                $alertMessage = '';
        ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="">

                    <input type="text" class="form-control mb-3" name="prenom" id="prenom" placeholder="Prénom" 
                    value="<?php echo $valuesInputed['prenom']; ?>">

                    <input type="text" class="form-control mb-3" name="email" id="email" placeholder="email" 
                    value="<?php echo $valuesInputed['email']; ?>">

                    <input type="password" class="form-control mb-3" name="mdp" id="mdp" placeholder="Nouveau mot de passe">

                    <input type="hidden" id="hiddenId" name="hiddenId" value="<?php echo $eventId;?>">

                    <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                        <?php echo $alertMessage; ?>
                    </p>

                    <div class="row">
                        <div class="col-6">
                            <a href="users.php?id=<?php echo $eventId; ?>">
                                <button type="button" class="btn btn-outline-danger w-100">Annuler</button>
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100">Modifier</button>
                        </div>
                    </div>
                </form>
        <?php } ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<?php 
}
else {
    header("Location: login.php");
    exit;
}
?>
</html>
