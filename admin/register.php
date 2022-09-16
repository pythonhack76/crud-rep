<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$livello = 0;
$username_err = $password_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Si prega di inserire un valore per username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Si prega di inserire un valore valido per password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM admin_users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            //Password is correct, so start a new session
                            // session_start();
                            // 
                           // Store data in session variables
                            // $_SESSION["loggedin"] = true;
                            // $_SESSION["id"] = $id;
                            // $_SESSION["username"] = $username; 
                            
                            
                //creazione modulo per inserimento dati su tabella Admin

                 // Prepare an insert statement
 $sql = "INSERT INTO admin_users (username, password, livello) VALUES (:username, :password, :livello)";
 if($stmt = $pdo->prepare($sql)){
     // Bind variables to the prepared statement as parameters
     $stmt->bindParam(":username", $param_username);
     $stmt->bindParam(":password", $param_password);
     $stmt->bindParam(":livello", $param_livello);
     
     // Set parameters
     $param_username = $username;
     $param_password = $password;
     $param_livello = $livello;
     
     // Attempt to execute the prepared statement
     if($stmt->execute()){
         // Records created successfully. Redirect to landing page
         header("location: index.php");
         exit();
     } else{
         echo "Oops! Something went wrong. Please try again later.";
     }
 }

            //dovremmo aver inserito i dati 

                        
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrazione Nuovo Utente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./admin-style.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <h2>Registrazione Nuovo Admin</h2>
        <p>Si prega di compilare tutti i campi per registrare un nuovo Utente Admin.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register">
            </div>
            <p>Hai già un account? <a href="login.php">Accedi adesso!</a>.</p>
        </form>
    </div>
    <div class="footer-img"><img src="./imgs/admin-workers.jpg"></div>
   
</body>
</html>