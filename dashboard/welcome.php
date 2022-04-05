<?php
// Initialize the session
session_start();
 
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
    <title>Benvenuto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Benevenuto nella tua area riservata.</h1>
   
   <div class="container">
       <p>
           <img src="" alt="immagine dashboard">
       </p>
   </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset per la password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Esci ora da Account</a>
    </p>
    <div class="footer-img"><img src="./imgs/dashboard.jpg"></div>
</body>
</html>