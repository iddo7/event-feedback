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
    <link rel="stylesheet" href="style/scss/compiled-variables.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Event Feedback</title>
</head>
<?php 
if ($_SESSION["connexion"] == true) {
    
?>
<body>
<nav class="navbar navbar-expand-lg navbar-light ps-5">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../index.php">Event Feedback</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="index.php">Accueil</span></a>
            <a class="nav-item nav-link" href="php/events.php">Évènements</a>
            <a class="nav-item nav-link" href="php/users.php">Usagers</a>
            <a class="nav-item nav-link" href="php/logout.php">Se déconnecter</a>
        </div>
    </div>
</nav>
    <div class="container screen-center">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1>Accueil</h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-4 me-5">
                <a href="php/users.php" class="card shadow p-5 text-center">
                    <i class="choose-icon fa-solid fa-users-gear mb-3"></i>
                    <h2>Utilisateurs</h2>
                </a>
            </div>
            <div class="col-4">
                <a href="php/events.php" class="card shadow p-5 text-center">
                    <i class="choose-icon fa-solid fa-calendar-days mb-3"></i>
                    <h2>Évènements</h2>
                </a>
            </div>
        </div>
    </div>
<?php 
}
else {
    header("Location: php/login.php");
    exit;
}
?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>