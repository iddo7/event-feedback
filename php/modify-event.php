<?php
session_start();
?>
<?php include 'navbar.php'; ?>
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
            transform: translateY(-0px);
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
        "name" => "",
        "date" => "",
        "description" => "",
        "img" => "",
        "departementId" => "",
        "place" => "", 
    );
    $errorOccured = false;
    $alertMessage = '';

    $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("name", "date", "description", "img", "departementId", "place");

        if (anyIsEmpty($inputs)) {
            $errorOccured = true;
            $alertMessage = 'Veuillez remplir tous les champs.';
        }

        for ($i = 0; $i < sizeof($inputs); $i++) {
            $keys = array_keys($valuesInputed);
            $valuesInputed[$keys[$i]] = trojan($_POST[$inputs[$i]]);
        }

        if (!$errorOccured) {


            $connection = mysqli_connect($servername, $username, $password, $db);

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $connection->query('SET NAMES utf8');

            $updatedEvent_name = $valuesInputed['name'];
            $updatedEvent_description = $valuesInputed['description'];
            $updatedEvent_date = $valuesInputed['date'];
            $updatedEvent_img = $valuesInputed['img'];
            $updatedEvent_departementId = $valuesInputed['departementId'];
            $updatedEvent_place = $valuesInputed['place'];
            $updateQuery = "UPDATE events SET name='{$updatedEvent_name}', description=\"{$updatedEvent_description}\", date='{$updatedEvent_date}', img='{$updatedEvent_img}', departementId={$updatedEvent_departementId}, place='{$updatedEvent_place}' WHERE id={$eventId}";

            if ($connection->query($updateQuery) === TRUE) {
                $alertMessage = "L'ajout s'est bien produit";
                header("Location: events.php");
                exit;
            } else {
                $alertMessage = "Erreur updating record : " . $connection->error;
                $errorOccured = true;
            }

            mysqli_close($connection);
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
    <div class="p-4 screen-center col-12 col-md-6 col-xl-4">
        <h1 class="text-center">Modifier évènement</h1>
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
            $connection->query('SET NAMES utf8');

            $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];
            $selectAllQuery = "SELECT * FROM events WHERE id=" . $eventId;
            $result = $connection->query($selectAllQuery);
            if ($result->num_rows <= 0) {
                echo "0 results";
            }

            while ($row = $result->fetch_assoc()) {
                $valuesInputed = array(
                    "name" => $row["name"],
                    "description" => $row["description"],
                    "date" => $row["date"],
                    "img" => $row["img"],
                    "departementId" => $row["departementId"],
                    "place" => $row["place"],
                );
            }
            $errorOccured = false;
            $alertMessage = '';
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">

                <div class="row">
                    <div class="col-6">
                        <label id="nameLabel" class="label show" for="name">Nom de l'évènement</label>
                        <input type="text" class="form-control mb-2" name="name" id="name" value="<?php echo $valuesInputed['name']; ?>">
                    </div>
                    <div class="col-6">
                        <label id="dateLabel" class="label show" for="date">Date</label>
                        <input type="date" class="form-control mb-2" name="date" id="date" value="<?php echo $valuesInputed['date']; ?>">
                    </div>
                </div>

                <label id="placeLabel" class="label show" for="place">Lieu</label>
                <input type="text" class="form-control mb-2" name="place" id="place" value="<?php echo $valuesInputed['place']; ?>">

                <label id="imgLabel" class="label show" for="img">URL de l'image</label>
                <input type="text" class="form-control mb-2" name="img" id="img" value="<?php echo $valuesInputed['img']; ?>">

                <label id="departementIdLabel" class="label show" for="departementId">Département</label>
                <select class="form-select mb-2" aria-label="Default select example" id="departementId" name="departementId">
                    <?php
                    $selectedDepartmentId = $valuesInputed['departementId'];
                    ?>
                    <option value="-1" <?php echo ($selectedDepartmentId == -1) ? 'selected' : ''; ?>>Choisissez un département</option>

                    <?php
                    $servername = "localhost";
                    $usernameDB = "root";
                    $passwordDB = "root";
                    $db = "event_feedback";
                    $conn = mysqli_connect($servername, $usernameDB, $passwordDB, $db);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $conn->query('SET NAMES utf8');

                    $query = "SELECT `id`, `name` FROM `departements`";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selectedAttribute = ($selectedDepartmentId == $row["id"]) ? 'selected' : '';

                            echo '<option value="' . $row["id"] . '" ' . $selectedAttribute . '>' . $row["name"] . '</option>';
                        }
                    }

                    mysqli_close($conn);
                    ?>
                </select>

                <label id="descriptionLabel" class="label show" for="description">Description</label>
                <textarea class="form-control mb-2" name="description" id="description" rows="4" style="max-height: 200px;" maxlength="500"><?php echo $valuesInputed['description']; ?></textarea>

                <input type="hidden" id="hiddenId" name="hiddenId" value="<?php echo $eventId; ?>">

                <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                    <?php echo $alertMessage; ?>
                </p>

                <div class="row">
                    <div class="col-6">
                        <a href="event-info.php?id=<?php echo $eventId; ?>">
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
