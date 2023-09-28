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
    <title>create-user</title>
</head>
<?php


function anyIsEmpty($arrayOfInputs)
{
    $result = false;
    foreach ($arrayOfInputs as $input) {
        if (empty($_POST[$input])) {
            $result = true;
            break;
        }
    }

    return $result;
}

function trojan($data)
{
    $data = trim($data); //Enleve les caractères invisibles
    $data = addslashes($data); //Mets des backslashs devant les ' et les  "
    $data = htmlspecialchars($data); // Remplace les caractères spéciaux par leurs symboles comme ­< devient &lt;

    return $data;
}

if ($_SESSION["connexion"] == true) {

    $valuesInputed = array(
        "email" => "",
        "mdp" => "",
        "verification" => "",
    );
    $errorOccured = false;
    $alertMessage = '';


    // FORM WAS SUBMITTED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("email", "mdp", "verification"); // Add 'verification' to the inputs

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

        // Check if password and verification match
        if ($_POST['mdp'] !== $_POST['verification']) {
            $errorOccured = true;
            $alertMessage = 'Le mot de passe et la confirmation ne correspondent pas.';
        }

        for ($i = 0; $i < sizeof($inputs); $i++) {
            $keys = array_keys($valuesInputed);
            $valuesInputed[$keys[$i]] = trojan($_POST[$inputs[$i]]);
        }

        if (!$errorOccured) {

            $servername = "localhost";
            $usernameDB = "root";
            $passwordDB = "root";
            $db = "event_feedback";


            $conn = mysqli_connect($servername, $usernameDB, $passwordDB, $db);

            if (!$conn) {

                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO users (email, password)
            VALUES ('" . $valuesInputed['email'] . "','" . $valuesInputed['mdp'] . "');";

            if (mysqli_query($conn, $sql)) {
                header("Location: ../index.php");
                exit;
            } else {
                echo "Error:" . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mt-5">
                <span class="logo">Create user</span>
            </div>
        </div>
    </div>
    <div class="p-4 screen-center col-12 col-md-6 col-xl-3">
        <h1 class="text-center">Créer utilisateur</h1>
        <hr>

        <?php
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">

                <input type="text" class="form-control mb-3" name="email" id="email" placeholder="Email" value="<?php echo $valuesInputed['email']; ?>">

                <input type="password" class="form-control mb-3" name="mdp" id="mdp" placeholder="Mot de passe" value="<?php echo $valuesInputed['mdp']; ?>">

                <input type="password" class="form-control mb-3" name="verification" id="verification" placeholder="Confirmer">

                <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                    <?php echo $alertMessage; ?>
                </p>

                <button type="submit" class="btn btn-primary w-100">Suivant</button>
            </form>
        <?php } } else {
            header("Location: login.php");
            exit;
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
