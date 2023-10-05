<?php
session_start();
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
            $connection->query('SET NAMES utf8');

            $selectUserQuery = "SELECT * FROM users WHERE email='$username' AND password='$password'";
            $result = $connection->query($selectUserQuery);
            
            if (!empty($result)) {
                if ($result->num_rows > 0) {
                    // Connected
                    $row = $result->fetch_assoc();
                    $_SESSION["connexion"] = true;
                    
                    header("Location: ../index.php");
                    exit;
                }
                else {
                    $errorOccured = true;
                    $alertMessage = "Le nom d'usager et le mot de passe ne correspondent pas.";
                }
            }
            else {
                $errorOccured = true;
                $alertMessage = "Le nom d'usager et le mot de passe ne correspondent pas.";
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
    <div class="p-4 screen-center col-12 col-md-6 col-xl-3">
        <h1 class="text-center">Connexion</h1>
        <hr>

        <?php 
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {
        ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="">

                    <label for="username">Nom d'usager</label>
                    <input type="text" class="form-control mb-3" name="username" id="username" placeholder="Nom d'usager" 
                        value="<?php echo $valuesInputed['username']; ?>">

                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Mot de passe" 
                        value="<?php echo $valuesInputed['password']; ?>">

                    <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                        <?php echo $alertMessage; ?>
                    </p>

                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
        <?php } ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
