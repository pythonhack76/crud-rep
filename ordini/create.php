<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$nrordine = $articolo = $descrizione = $qta = $prezzo = $idcliente = "";
$nrordine_err = $articolo_err = $descrizione_err = $qta_err = $prezzo_err = $idcliente_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate articolo
    $input_name = trim($_POST["articolo"]);
    if(empty($input_articolo)){
        $articolo_err = "Please inserisci un articolo.";
    } elseif(!filter_var($input_articolo, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $articolo_err = "Please inserisci un contenuto per articolo!";
    } else{
        $articolo = $input_articolo;
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
    if(empty($name_err) && empty($address_err) && empty($rating_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO ordini (name, address, rating) VALUES (:name, :address, :rating)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
           
            $stmt->bindParam(":nrordine", $param_nrordine);
            $stmt->bindParam(":articolo", $param_articolo);
            $stmt->bindParam(":descrizione", $param_descrizione);
            $stmt->bindParam(":qta", $param_qta);
            $stmt->bindParam(":prezzo", $param_prezzo);
            $stmt->bindParam(":idcliente", $param_idcliente);
            
            // Set parameters
            $param_nrordine = $nrordine; 
            $param_articolo = $articolo; 
            $param_descrizione = $descrizione;
            $param_qta = $rating;
            
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
    <title>Crea Nuovo Ordine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                    <h2 class="mt-5">Crea Nuovo Ordine</h2>
                    <p>Per favore compila tutti i campi per poter aggiungere un nuovo ordine al database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nr Ordine</label>
                            <input type="text" name="nrordine" class="form-control <?php echo (!empty($nrordine_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nrordine; ?>">
                            <span class="invalid-feedback"><?php echo $nrordine_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Indirizzo</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>citta</label>
                            <input type="text" name="rating" class="form-control <?php echo (!empty($rating_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rating; ?>">
                            <span class="invalid-feedback"><?php echo $rating_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancella</a>
                    </form>
                    <div class="footer-img"><img src="./imgs/ordini.jpg"></div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>