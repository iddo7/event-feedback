<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <title>event-info</title>
</head>
<body>
<div class="container-fluid vh-100">
    <div class="row height100">
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
            
                $eventId = isset($_GET["id"]) ? $_GET["id"] : $_POST["hiddenId"];
                $selectAllQuery = "SELECT * FROM events WHERE id=" . $eventId;
                $result = $connection->query($selectAllQuery);
                if ($result->num_rows <= 0) {
                    echo "0 results";
                }
                while($row = $result->fetch_assoc()) {
                    $valuesInputed = array(
                        "name" => $row["name"],
                        "artistName" => $row["artiste"],
                        "image" => $row["img"],
                        "numberOfSongs" => $row["nmbDePistes"],
                        "releaseDate" => $row["dateDeSortie"],
                    );
                }

                $errorOccured = false;
                $alertMessage = '';
        ?>
            <div class="col-md-6 height100">
                <div class="card border-0 height100">
                    <img class="card-img-top height100" src="https://riotfest.org/wp-content/uploads/2016/10/151_1stuffed_crust_pizza.jpg" alt="Card image cap">
                </div>
            </div>
            <div class="col-md-6 height100 d-flex align-items-center">
                <div class="card border-0 mx-auto">
                    <div class="card-body text-center">
                        <h5 class="card-title text-center display-3 mb-5"><?php echo $row["name"] ?></h5>
                        <p class="card-text m-5" style="font-size: 2rem;">Date: </p>
                        <p class="card-text m-5" style="font-size: 2rem;">Infos: </p>
                        <div class="row">
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>
                                <h2 class="display-5">1</h2>                                              
                            </div>
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>
                                <h2 class="display-5">2</h2>                                              
                            </div>
                            <div class="col-md-4 cercle">
                                <i class="fa-solid fa-circle" style="color: #59eb24;"></i>  
                                <h2 class="display-5">3</h2>                      
                            </div>
                        </div>
                        <div class="d-flex justify-content-center m-5">
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
