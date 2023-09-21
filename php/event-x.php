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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <title>event-info</title>
</head>
<body>

<?php 
if ($_SESSION["connexion"] == true) {

?>

<div class="container-fluid screen-center-y">
    <div class="row text-center cercle-x">
        <div class="col-sm-4 col-md-4">
            <i class="fa-solid fa-circle img-fluid" style="color: #008a64;"></i>
        </div>
        <div class="col-sm-4 col-md-4">
            <i class="fa-solid fa-circle" style="color: #ffc45d;"></i>
        </div>
        <div class="col-sm-4 col-md-4">
            <i class="fa-solid fa-circle" style="color: #df2350;"></i>
        </div>
    </div>
</div>
<div class="m-5 fleche-retour">
    <i class="fa-sharp fa-solid fa-arrow-left"></i>
</div>
<div class="fixed-bottom text-center mb-4">
    <span class="">vote étudiant</span>
</div>

<?php 
}
else {
    header("Location: login.php");
    exit;
}
?>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
