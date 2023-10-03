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
    <title>Event Feedback</title>
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
        "name" => "",
        "date" => "",
        "description" => "",
        "img" => "",
        "departementId" => "",
        "place" => "", // Ajout du champ "lieu"
    );
    $errorOccured = false;
    $alertMessage = '';


    // FORM WAS SUBMITTED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("name", "date", "description", "img", "departementId", "place"); // Ajout de "lieu"

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
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

            $sql = "INSERT INTO events (name, date, description, img, departementId, place) 
            VALUES ('" . $valuesInputed['name'] . "','" . $valuesInputed['date'] . "','" . $valuesInputed['description'] . "','" . $valuesInputed['img'] . "','" . $valuesInputed['departementId'] . "','" . $valuesInputed['place'] . "');";

            if (mysqli_query($conn, $sql)) {
                header("Location: events.php");
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
                <span class="logo">Event Feedback</span>
            </div>
        </div>
    </div>
    <div class="p-4 screen-center col-12 col-md-6 col-xl-4">
        <h1 class="text-center">Ajouter évènement</h1>
        <hr>

        <?php
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">

                <div class="row">
                    <div class="col-6">
                        <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Nom de l'évènement" value="<?php echo $valuesInputed['name']; ?>">
                    </div>
                    <div class="col-6">
                        <input type="date" class="form-control mb-3" name="date" id="date" value="<?php echo $valuesInputed['date']; ?>">
                    </div>
                </div>

                <input type="text" class="form-control mb-3" name="place" id="place" placeholder="lieu" value="<?php echo $valuesInputed['place']; ?>">

                <input type="text" class="form-control mb-3" name="img" id="img" placeholder="URL de l'image" value="<?php echo $valuesInputed['img']; ?>">

                <select class="form-select mb-3" aria-label="Default select example" id="departementId" name="departementId">
                    <?php
                    $selectedDepartmentId = $valuesInputed['departementId'];
                    ?>
                    <option value="-1" <?php echo ($selectedDepartmentId == -1) ? 'selected' : ''; ?>>Choisissez un département</option>

                    <?php
                    // Database connection
                    $servername = "localhost";
                    $usernameDB = "root";
                    $passwordDB = "root";
                    $db = "event_feedback";
                    $conn = mysqli_connect($servername, $usernameDB, $passwordDB, $db);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $conn->query('SET NAMES utf8');

                    // Query to fetch departments
                    $query = "SELECT `id`, `name` FROM `departements`";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selectedAttribute = ($selectedDepartmentId == $row["id"]) ? 'selected' : '';

                            echo '<option value="' . $row["id"] . '" ' . $selectedAttribute . '>' . $row["name"] . '</option>';
                        }
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </select>

                <textarea class="form-control mb-3" name="description" id="description" placeholder="Description" rows="4" style="max-height: 200px;" maxlength="500"><?php echo $valuesInputed['description']; ?></textarea>


                <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                    <?php echo $alertMessage; ?>
                </p>

                <div class="row">
                    <div class="col-6">
                        <a href="events.php">
                            <button type="button" class="btn btn-outline-danger w-100">Annuler</button>
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
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
</body>

</html>
