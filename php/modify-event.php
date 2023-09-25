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
        "name" => "",
        "date" => "",
        "description" => "",
        "img" => "",
        "department" => "",
    );
    $errorOccured = false;
    $alertMessage = '';


    // FORM WAS SUBMITTED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $inputs = array("name", "date", "description", "img", "department");

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
        <h1 class="text-center">Ajouter évènement</h1>
        <hr>

        <?php 
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || $errorOccured == true) {
        ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="">

                    <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Nom de l'évènement" 
                        value="<?php echo $valuesInputed['name']; ?>">

                    <input type="date" class="form-control mb-3" name="date" id="date" placeholder="" 
                    value="<?php echo $valuesInputed['date']; ?>">

                    <input type="text" class="form-control mb-3" name="img" id="img" placeholder="URL de l'image" 
                    value="<?php echo $valuesInputed['img']; ?>">

                    <input type="text" class="form-control mb-3" name="department" id="department" placeholder="Département" 
                        value="<?php echo $valuesInputed['department']; ?>">

                    <textarea class="form-control mb-3" name="description" id="description" 
                    placeholder="Description" rows="4" style="max-height: 200px;" maxlength="500"><?php echo $valuesInputed['description']; ?></textarea>


                    <p class="text-<?php echo $errorOccured == true ? "danger" : "success" ?>">
                        <?php echo $alertMessage; ?>
                    </p>

                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </form>
        <?php } ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>