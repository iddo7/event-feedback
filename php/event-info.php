<?php
session_start();
?>
<?php 
include 'navbar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/scss/compiled-variables.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Event Feedback</title>
</head>
<body>
<?php 
if ($_SESSION["connexion"] == true) {
    
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
        $selectAllQuery = "SELECT events.*, departements.name AS departmentName FROM events 
                  JOIN departements ON events.departementId = departements.id 
                  WHERE events.id=" . $eventId;
        $result = $connection->query($selectAllQuery);
        if ($result->num_rows <= 0) {
            echo "0 results";
        }
        while ($row = $result->fetch_assoc()) {
            $valuesInputed = array(
                "name" => $row["name"],
                "date" => $row["date"],
                "place" => $row["place"],
                "description" => $row["description"],
                "img" => $row["img"],
                "departmentName" => $row["departmentName"], // Use department_name instead of departementId
                "studentVotesGreen" => $row["studentVotesGreen"],
                "studentVotesYellow" => $row["studentVotesYellow"],
                "studentVotesRed" => $row["studentVotesRed"],
                "professionalVotesGreen" => $row["professionalVotesGreen"],
                "professionalVotesYellow" => $row["professionalVotesYellow"],
                "professionalVotesRed" => $row["professionalVotesRed"],
            );
        }

        $errorOccured = false;
        $alertMessage = '';
?>
<div class="container-fluid p-0 mb-4">
    <div class="p-5 bg-darker">
        <div class="row event-info-details">
            <div class="col-4 event-img" style="background: url('<?php echo $valuesInputed["img"] ?>')"></div>
            <div class="col-8 ps-4">
                <div class="row mb-2 d-flex ajust-items-center">
                    <div class="col-8">
                        <h1 class="m-0"><?php echo $valuesInputed["name"] ?></h1>
                    </div>
                    <div class="col-4">
                        <a href="choose-vote-type.php?id=<?php echo $eventId ?>" class="d-flex justify-content-end">
                            <button class="btn btn-primary vote-btn btn-lg">
                                <i class="fa-solid fa-check-to-slot"></i>
                                Voter
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-9 col-xl-10">
                        <span class="small me-3"><?php echo $valuesInputed["date"] ?></span>
                        <span class="small me-3"><?php echo $valuesInputed["place"] ?></span>
                        <span class="small me-3"><?php echo $valuesInputed["departmentName"] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-xl-10">
                        <p><?php echo $valuesInputed["description"] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>

    </div>
</div>
<div class="container">
    <div class="row justify-content-center">

        <!-- Professional Votes Section -->
        <div class="card col-11 col-md-10 col-lg-5 shadow m-4">
            <div class="row p-3">
                <div class="col-12 p-0">
                    <h2 class="m-0">Professionels</h2>
                </div>
            </div>
            <div class="row p-3 text-center">
                <div class="col-12 p-0">
                    <div id="professional-chart" style="height: 35vh"></div>
                </div>
            </div>
        </div>

        <!-- Student Votes Section -->
        <div class="card col-11 col-md-10 col-lg-5 shadow m-4">
            <div class="row p-3">
                <div class="col-12 p-0">
                    <h2 class="m-0">Étudiants</h2>
                </div>
            </div>
            <div class="row p-3 text-center">
                <div class="col-12 p-0">
                    <div id="student-chart" style="height: 35vh"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-2">
            <a href="modify-event.php?id=<?php echo $eventId ?>" class="w-100">
                <button class="btn btn-outline-primary vote-btn w-100">Modifier</button>
            </a>
        </div>
        <div class="col-2">
            <a href="delete-event.php?id=<?php echo $eventId ?>" class="w-100">
                <button class="btn btn-outline-danger vote-btn w-100">Supprimer</button>
            </a>
        </div>
    </div>
</div>

<!-- Charts Script -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});

  google.charts.setOnLoadCallback(drawStudentChart);
  google.charts.setOnLoadCallback(drawProfessionalChart);

  let green = '#1a9f6b'
  let yellow = '#ffc45d'
  let red = '#d72a54'

    // Student Chart
    function drawStudentChart() {
        var data = google.visualization.arrayToDataTable([
            ['', 'Mauvaise', 'Neutre', 'Bonne'],
            ['Expérience', <?php echo $valuesInputed['studentVotesRed']; ?>, 
                                                    <?php echo $valuesInputed['studentVotesYellow']; ?>, 
                                                    <?php echo $valuesInputed['studentVotesGreen']; ?>],
        ]);
        var options = {
            chart: {
                subtitle: 'Expérience des étudiants',
            },
            colors: [red, yellow, green]
        };

        var chart = new google.charts.Bar(document.getElementById('student-chart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    // Professional Chart
    function drawProfessionalChart() {
        var data = google.visualization.arrayToDataTable([
            ['', 'Mauvaise', 'Neutre', 'Bonne'],
            ['Expérience', <?php echo $valuesInputed['professionalVotesRed']; ?>, 
                                                    <?php echo $valuesInputed['professionalVotesYellow']; ?>, 
                                                    <?php echo $valuesInputed['professionalVotesGreen']; ?>],
        ]);
        var options = {
            chart: {
                subtitle: 'Expérience des professionels',
            },
            colors: [red, yellow, green]
        };

        var chart = new google.charts.Bar(document.getElementById('professional-chart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php 
}
}
else {
    header("Location: login.php");
    exit;
}
?>
</body>
</html>
