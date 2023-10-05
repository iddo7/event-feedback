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
    <link rel="stylesheet" href="../style/scss/compiled-variables.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>event-feedback</title>

    <style>
        .label {
            opacity: 0;
            transform: translateY(0);
            transition: opacity 0.3s, transform 0.3s;
        }

        .label.show {
            opacity: 1;
            transform: translateY(-0px);
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
        "verification" => "",
    );
    $errorOccured = false;
    $alertMessage = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("prenom", "email", "mdp", "verification");

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

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
            $conn->query('SET NAMES utf8');

            $sql = "INSERT INTO users (prenom, email, password)
            VALUES ('" . $valuesInputed['prenom'] . "','" . $valuesInputed['email'] . "','" .  $valuesInputed['mdp'] = md5($_POST['mdp']) . "');";

            if (mysqli_query($conn, $sql)) {
                header("Location: users.php");
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

                <label id="prenomLabel" class="label" for="prenom">Prénom</label>
                <input type="text" class="form-control mb-2" name="prenom" id="prenom" placeholder="Prénom" value="<?php echo $valuesInputed['prenom']; ?>">

                <label id="emailLabel" class="label" for="email">Email</label>
                <input type="text" class="form-control mb-2" name="email" id="email" placeholder="Email" value="<?php echo $valuesInputed['email']; ?>">

                <label id="mdpLabel" class="label" for="mdp">Mot de passe</label>
                <input type="password" class="form-control mb-2" name="mdp" id="mdp" placeholder="Mot de passe" value="<?php echo $valuesInputed['mdp']; ?>">

                <label id="verificationLabel" class="label" for="verification">Confirmer le mot de passe</label>
                <input type="password" class="form-control mb-4" name="verification" id="verification" placeholder="Confirmer">

                <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                    <?php echo $alertMessage; ?>
                </p>

                <div class="row">
                    <div class="col-6">
                        <a href="users.php">
                            <button type="button" class="btn btn-outline-danger w-100">Annuler</button>
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Créer</button>
                    </div>
                </div>
            </form>
        <?php } } else {
            header("Location: login.php");
            exit;
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prenomInput = document.getElementById('prenom');
            const emailInput = document.getElementById('email');
            const mdpInput = document.getElementById('mdp');
            const verificationInput = document.getElementById('verification');

            const prenomInputLabel = document.getElementById('prenomLabel');
            const emailInputLabel = document.getElementById('emailLabel');
            const mdpInputLabel = document.getElementById('mdpLabel');
            const verificationInputLabel = document.getElementById('verificationLabel');

            const inputs = [
                { input: prenomInput, label: prenomInputLabel },
                { input: emailInput, label: emailInputLabel },
                { input: mdpInput, label: mdpInputLabel },
                { input: verificationInput, label: verificationInputLabel }
            ];

            inputs.forEach(({ input, label }) => {
                input.addEventListener('input', function() {
                    if (input.value !== '') {
                        label.classList.add('show');
                    } else {
                        label.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>

</html>
