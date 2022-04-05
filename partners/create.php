<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$name = $cognome =  $address = $rating = "";
$name_err = $cognome_err = $address_err = $rating_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

     // Validate cognome
     $input_cognome = trim($_POST["cognome"]);
     if(empty($input_cognome)){
         $cognome_err = "prego inserisci il tuo cognome.";
     } elseif(!filter_var($input_cognome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
         $cognome_err = "Prego insersci un contenuto valido.";
     } else{
         $cognome = $input_cognome;
     }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate rating
    $input_rating = trim($_POST["rating"]);
    if(empty($input_rating)){
        $rating_err = "Please enter the rating amount.";     
    } elseif(!ctype_digit($input_rating)){
        $rating_err = "Please enter a positive integer value.";
    } else{
        $rating = $input_rating;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($cognome_err) && empty($address_err) && empty($rating_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO partners (name, cognome, address, rating) VALUES (:name, :cognome, :address, :rating)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":cognome", $param_cognome);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":rating", $param_rating);
            
            // Set parameters
            $param_name = $name;
            $param_cognome = $cognome;
            $param_address = $address;
            $param_rating = $rating;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crea Partner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./styles.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Aggiungi nuovo Partner</h2>
                    <p>Per favore compila tutti i campi per poter aggiungere un nuovo dipendente al database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cognome</label>
                            <input type="text" name="cognome" class="form-control <?php echo (!empty($cognome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $cognome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Indirizzo</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <input type="text" name="rating" class="form-control <?php echo (!empty($rating_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rating; ?>">
                            <s
                            pan class="invalid-feedback"><?php echo $rating_err;?></s>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancella</a>
                    </form>
                    <div class="footer-img"><img src="./imgs/add-partners.jpg"></div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>