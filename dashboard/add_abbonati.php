<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$nome = $cognome = $indirizzo = $citta = $email = $telefono =  "";
$nome_err = $cognome_err = $indirizzo_err = $citta_err = $email_err = $telefono_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Please enter a name.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Please enter a valid name.";
    } else{
        $nome = $input_nome;
    }
    
    // Validate indirizzo
    $input_indirizzo = trim($_POST["indirizzo"]);
    if(empty($input_indirizzo)){
        $indirizzo_err = "Please enter an indirizzo.";     
    } else{
        $indirizzo = $input_indirizzo;
    }
    
    // Validate citta
    $input_citta = trim($_POST["citta"]);
    if(empty($input_citta)){
        $citta_err = "Please enter the citta amount.";     
    } elseif(!ctype_digit($input_citta)){
        $citta_err = "Please enter a positive integer value.";
    } else{
        $citta = $input_citta;
    }
    
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($indirizzo_err) && empty($citta_err) && empty($email_err) && empty($telefono_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO abbonati (nome, indirizzo, citta, email, telefono) VALUES (:nome, :indirizzo, :citta, :email, :telefono)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":nome", $param_nome);
            $stmt->bindParam(":indirizzo", $param_indirizzo);
            $stmt->bindParam(":citta", $param_citta);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":telefono", $param_telefono);
            
            
            // Set parameters
            $param_nome = $nome;
            $param_indirizzo = $indirizzo;
            $param_citta = $citta;
            $param_email = $email;
            $param_telefono = $telefono;
            
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
    <title>Aggiungi Abbonato</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles.css">
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
                    <h2 class="mt-5">Aggiungi Abbonato</h2>
                    <p>Per favore compila tutti i campi per poter aggiungere un nuovo collaboratore al database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Indirizzo</label>
                            <textarea name="indirizzo" class="form-control <?php echo (!empty($indirizzo_err)) ? 'is-invalid' : ''; ?>"><?php echo $indirizzo; ?></textarea>
                            <span class="invalid-feedback"><?php echo $indirizzo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>citta</label>
                            <input type="text" name="citta" class="form-control <?php echo (!empty($citta_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $citta; ?>">
                            <span class="invalid-feedback"><?php echo $citta_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancella</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <div class="footer-img"><img src="./imgs/abbonato.jpg"></div>
</body>
</html>