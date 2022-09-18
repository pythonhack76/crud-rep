<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$nome = $cognome = $indirizzo = $citta = $email = $telefono = "";
$nome_err = $cognome_err = $indirizzo_err = $citta_err =  $email_err = $telefono_err = "";
 
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
    $name_err = "Please enter a cognome.";
} elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    $name_err = "Please enter a valid cognome.";
} else{
    $cognome = $input_cognome;
}
    
    
    // Validate address
    $input_address = trim($_POST["indirizzo"]);
    if(empty($input_indirizzo)){
        $indirizzo_err = "Please enter an address.";     
    } else{
        $indirizzo = $input_indirizzo;
    }
    
    // Validate rating
    $input_citta = trim($_POST["citta"]);
    if(empty($input_citta)){
        $citta_err = "Si prega di inserire un nome di città valido";     
    } elseif(!ctype_digit($input_citta)){
        $citta_err = "Please enter a positive integer value.";
    } else{
        $citta = $input_citta;
    }
    
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($cognome_err) && empty($indirizzo_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clienti (nome, cognome, indirizzo, citta, email, telefono) VALUES (:name, :cognome, :indirizzo, :citta, :email, :telefono)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":nome", $param_nome);
            $stmt->bindParam(":cognome", $param_cognome);
            $stmt->bindParam(":indirizzo", $param_indirizzo);
            $stmt->bindParam(":citta", $param_citta);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":telefono", $param_telefono);
            
            // Set parameters
            $param_nome = $nome;
            $param_cognome = $cognome;
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
                    <h2 class="mt-5">Aggiungi Nuovo Cliente</h2>
                    <p>Per favore compila tutti i campi per poter aggiungere un nuovo cliente al database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

                     
                        <div class="form-group">
    <label>Cognome</label>
    <input type="text" name="cognome" class="form-control <?php echo (!empty($cognome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cognome; ?>">
    <span class="invalid-feedback"><?php echo $cognome_err;?></span>
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
                </div>
            </div>        
        </div>
    </div>
</body>
</html>