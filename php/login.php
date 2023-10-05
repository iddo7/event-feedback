<?php
session_start();
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
        $usernameLogin = $_POST['username'];
        $passwordLogin = md5($_POST['password'], false);            


        // Create connection
        $connection = new mysqli($servername, $username, $password, $db);
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $connection->query('SET NAMES utf8');

        $selectUserQuery = "SELECT * FROM users WHERE email='$usernameLogin' AND password='$passwordLogin'";
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
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);

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

                <label for="username" class="label">Nom d'usager</label>
                <input type="text" class="form-control mb-3" name="username" id="username" placeholder="Nom d'usager" 
                    value="<?php echo $valuesInputed['username']; ?>">

                <label for="password" class="label">Mot de passe</label>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            const usernameLabel = document.querySelector('label[for="username"]');
            const passwordLabel = document.querySelector('label[for="password"]');

            const inputs = [
                { input: usernameInput, label: usernameLabel },
                { input: passwordInput, label: passwordLabel },
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
