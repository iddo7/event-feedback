<?php
session_start();
include 'navbar.php';
?>
<?php include 'variables-db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/scss/compiled-variables.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Event Feedback</title>

    <style>
        .label {
            opacity: 1;
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
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

        $inputs = array("prenom", "email");

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

        for ($i = 0; $i < sizeof($inputs); $i++) {
            $keys = array_keys($valuesInputed);
            $valuesInputed[$keys[$i]] = trojan($_POST[$inputs[$i]]);
        }

        // Separate the password update logic
        $newPassword = "";
        if (!empty($_POST['mdp'])) {
            $newPassword = ", password='" . md5($_POST['mdp']) . "'";
        }

        if (!$errorOccured) {

            $connection = mysqli_connect($servername, $username, $password, $db);

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $connection->query('SET NAMES utf8');

            $prenom = $valuesInputed['prenom'];
            $email = $valuesInputed['email'];

            $updateQuery = "UPDATE users SET prenom='{$prenom}', email='{$email}'{$newPassword} WHERE id={$eventId}";

            if ($connection->query($updateQuery) === TRUE) {
                $alertMessage = "La mise à jour s'est bien déroulée";
                header("Location: users.php");
                exit;
            } else {
                $alertMessage = "Erreur lors de la mise à jour : " . $connection->error;
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

            while ($row = $result->fetch_assoc()) {
                $valuesInputed = array(
                    "prenom" => $row["prenom"],
                    "email" => $row["email"],
                    "password" => $row["password"],
                );
            }
            $errorOccured = false;
            $alertMessage = '';
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">

                <label for="prenom" class="label">Prénom</label>
                <input type="text" class="form-control mb-3" name="prenom" id="prenom" value="<?php echo $valuesInputed['prenom']; ?>">

                <label for="email" class="label">Email</label>
                <input type="text" class="form-control mb-3" name="email" id="email" value="<?php echo $valuesInputed['email']; ?>">

                <label for="mdp" class="label">Nouveau mot de passe</label>
                <input type="password" class="form-control mb-3" name="mdp" id="mdp">

                <input type="hidden" id="hiddenId" name="hiddenId" value="<?php echo $eventId; ?>">

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
} else {
    header("Location: login.php");
    exit;
}
?>

</html>
