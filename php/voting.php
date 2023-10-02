<?php
session_start();
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
    <link rel="stylesheet" href="../style/voting.css">
    <title>event-info</title>
</head>
<body>
<?php 
if ($_SESSION["connexion"] == true) {

    if (!isset($_GET["id"]) || $_GET["id"] == null || !isset($_GET["type"]) || $_GET["type"] == null) {
        header("Location: ../index.php");
        exit;
    }

    $eventId = $_GET["id"];
    $voteType = $_GET["type"];
?>

<div class="container screen-center">
    <div class="row text-center cercle-x">
        <div class="col-sm-4 col-md-4">
            <i id="icon-vote-green" class="icon-vote fa-solid fa-circle"></i>
        </div>
        <div class="col-sm-4 col-md-4">
            <i id="icon-vote-yellow" class="icon-vote fa-solid fa-circle"></i>
        </div>
        <div class="col-sm-4 col-md-4">
            <i id="icon-vote-red" class="icon-vote fa-solid fa-circle"></i>
        </div>
    </div>
</div>

<h1 class="message">Merci pour votre vote</h1>

<div class="m-5 fleche-retour">
    <a href="event-info.php?id=<?php echo $eventId ?>">
        <i class="fa-sharp fa-solid fa-arrow-left"></i>
    </a>
</div>
<div class="fixed-bottom text-center mb-4">
    <span class="display-vote-type">vote étudiant</span>
</div>

<?php 
}
else {
    header("Location: login.php");
    exit;
}
?>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../scripts/anime.min.js"></script>
<script src="../scripts/handleVote.js"></script>
</body>
</html>
