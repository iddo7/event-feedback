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

if ($_SESSION["connexion"] == true) {

    $valuesInputed = array(
        "name" => "",
        "date" => "",
        "description" => "",
        "img" => "",
        "departementId" => "",
        "place" => "", // Ajout de la valeur "place"
    );
    $errorOccured = false;
    $alertMessage = '';

    $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];

    // FORM WAS SUBMITTED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("name", "date", "description", "img", "departementId", "place"); // Ajout de "place" ici

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
            $username = "root";
            $password = "root";
            $db = "event_feedback";
        
            // Create connection
            $connection = mysqli_connect($servername, $username, $password, $db);
        
            // Check connection
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $connection->query('SET NAMES utf8');

            $updatedEvent_name = $valuesInputed['name'];
            $updatedEvent_description = $valuesInputed['description'];
            $updatedEvent_date = $valuesInputed['date'];
            $updatedEvent_img = $valuesInputed['img'];
            $updatedEvent_departementId = $valuesInputed['departementId'];
            $updatedEvent_place = $valuesInputed['place']; // Récupération de la valeur de "place"
            $updateQuery = "UPDATE events SET name='{$updatedEvent_name}', description=\"{$updatedEvent_description}\", date='{$updatedEvent_date}', img='{$updatedEvent_img}', departementId={$updatedEvent_departementId}, place='{$updatedEvent_place}' WHERE id={$eventId}"; // Ajout de "place" dans la requête SQL

            echo $updateQuery;

            if ($connection->query($updateQuery) === TRUE) {
                $alertMessage = "L'ajout s'est bien produit";
                header("Location: events.php");
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
        <h1 class="text-center">Modifier évènement</h1>
        <hr>

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
                $connection->query('SET NAMES utf8');
            
                $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];
                $selectAllQuery = "SELECT * FROM events WHERE id=" . $eventId;
                $result = $connection->query($selectAllQuery);
                if ($result->num_rows <= 0) {
                    echo "0 results";
                }
            
                while($row = $result->fetch_assoc()) {
                    $valuesInputed = array(
                        "name" => $row["name"],
                        "description" => $row["description"],
                        "date" => $row["date"],
                        "img" => $row["img"],
                        "departementId" => $row["departementId"],
                        "place" => $row["place"], // Récupération de la valeur de "place"
                    );
                }
                $errorOccured = false;
                $alertMessage = '';
        ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="">

                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Nom de l'évènement" value="<?php echo $valuesInputed['name']; ?>">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control mb-3" name="date" id="date" value="<?php echo $valuesInputed['date']; ?>">
                        </div>
                    </div>

                    <input type="text" class="form-control mb-3" name="place" id="lien" placeholder="place" 
                    value="<?php echo $valuesInputed['place']; ?>">

                    <input type="text" class="form-control mb-3" name="img" id="img" placeholder="URL de l'image" 
                    value="<?php echo $valuesInputed['img']; ?>">

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

                    <textarea class="form-control mb-3" name="description" id="description" 
                    placeholder="Description" rows="4" style="max-height: 200px;" maxlength="500"><?php echo $valuesInputed['description']; ?></textarea>

                    <input type="hidden" id="hiddenId" name="hiddenId" value="<?php echo $eventId;?>">

                    <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                        <?php echo $alertMessage; ?>
                    </p>

                    <div class="row">
                        <div class="col-6">
                            <?php 
                                $previousPage = $_GET['previousPage'];
                                if ($previousPage == 'eventInfo') {
                                    $cancelLink = "event-info.php?id=${eventId}";
                                }
                                else if ($previousPage == 'events') {
                                    $cancelLink = 'events.php';
                                }
                            ?>
                            <a href="<?php echo $cancelLink; ?>">
                                <button type="button" class="btn btn-outline-danger w-100">Annuler</button>
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100">Sauvegarder</button>
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
