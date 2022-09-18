<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$abbonamento = $descrizione = $prezzo = $attivo = "";
$attivo = 1; 
$abbonamento_err = $descrizione_err = $prezzo_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_abbonamento = trim($_POST["abbonamento"]);
    if(empty($input_abbonamento)){
        $abbonamento_err = "Please enter a name.";
    } elseif(!filter_var($input_abbonamento, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $abbonamento_err = "Please enter a valid name.";
    } else{
        $abbonamento = $input_abbonamento;
    }
    
    // Validate descrizione
    $input_descrizione = trim($_POST["descrizione"]);
    if(empty($input_descrizione)){
        $descrizione_err = "Please enter an descrizione.";     
    } else{
        $descrizione = $input_descrizione;
    }
    
    // Validate prezzo
    $input_prezzo = trim($_POST["prezzo"]);
    if(empty($input_prezzo)){
        $prezzo_err = "Please enter the prezzo amount.";     
    } elseif(!ctype_digit($input_prezzo)){
        $prezzo_err = "Please enter a positive integer value.";
    } else{
        $prezzo = $input_prezzo;
    }
    
    // Check input errors before inserting in database
    if(empty($abbonamento_err) && empty($descrizione_err) && empty($prezzo_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO abbonamenti (abbonamento, descrizione, prezzo, attivo) VALUES (:abbonamento, :descrizione, :prezzo, :attivo)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":abbonamento", $param_abbonamento);
            $stmt->bindParam(":descrizione", $param_descrizione);
            $stmt->bindParam(":prezzo", $param_prezzo);
            $stmt->bindParam(":attivo", $param_attivo);
            
            // Set parameters
            $param_abbonamento = $abbonamento;
            $param_descrizione = $descrizione;
            $param_prezzo = $prezzo;
            $param_attivo = $attivo; 
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: view_abbonamenti.php");
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
    <title>Crea Collaboratore</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Aggiungi Abbonamento</h2>
                    <p>Per favore compila tutti i campi per poter aggiungere un nuovo collaboratore al database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>abbonamento</label>
                            <input type="text" name="abbonamento" class="form-control <?php echo (!empty($abbonamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $abbonamento; ?>">
                            <span class="invalid-feedback"><?php echo $abbonamento_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>descrizione</label>
                            <textarea name="descrizione" class="form-control <?php echo (!empty($descrizione_err)) ? 'is-invalid' : ''; ?>"><?php echo $descrizione; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descrizione_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>prezzo</label>
                            <input type="text" name="prezzo" class="form-control <?php echo (!empty($prezzo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prezzo; ?>">
                            <span class="invalid-feedback"><?php echo $prezzo_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancella</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>