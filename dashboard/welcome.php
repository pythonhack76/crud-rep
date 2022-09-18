<?php
// Initialize the session
session_start();

include('../functions.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php TitlePage(); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <?php include_once("../include/header.php"); ?>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Benvenuto nella tua area riservata.</h1>
   
   <div class="container">
       <p>           
       </p>
   </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset per la password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Esci ora da Account</a>
    </p>
    <div class="footer-img"><img src="./imgs/dashboard.jpg"></div>
    <div class="servizi">
    <p>
     <a href="view-abbonamenti.php" class="btn btn-warning">Abbonamenti</a>
     <a href="add_abbonati.php" class="btn btn-danger ml-3">Gestisci Abbonati</a>
 </p>
    </div>
</body>
</html>