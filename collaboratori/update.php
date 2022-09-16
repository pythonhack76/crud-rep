<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$nome = $indirizzo = $compenso = "";
$nome_err = $indirizzo_err = $compenso_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["nome"]);
    if(empty($input_name)){
        $nome_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Please enter a valid name.";
    } else{
        $nome = $input_name;
    }
    
    // Validate indirizzo indirizzo
    $input_indirizzo = trim($_POST["indirizzo"]);
    if(empty($input_indirizzo)){
        $indirizzo_err = "Please enter an indirizzo.";     
    } else{
        $indirizzo = $input_indirizzo;
    }
    
    // Validate compenso
    $input_compenso = trim($_POST["compenso"]);
    if(empty($input_compenso)){
        $compenso_err = "Please enter the compenso amount.";     
    } elseif(!ctype_digit($input_compenso)){
        $compenso_err = "Please enter a positive integer value.";
    } else{
        $compenso = $input_compenso;
    }
    
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($indirizzo_err) && empty($compenso_err)){
        // Prepare an update statement
        $sql = "UPDATE collaboratori SET nome=:nome, indirizzo=:indirizzo, compenso=:compenso WHERE CollaboratoreID =:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":nome", $param_nome);
            $stmt->bindParam(":indirizzo", $param_indirizzo);
            $stmt->bindParam(":compenso", $param_compenso);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_nome = $nome;
            $param_indirizzo = $indirizzo;
            $param_compenso = $compenso;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM collaboratori WHERE CollaboratoreID = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $nome = $row["nome"];
                    $indirizzo = $row["indirizzo"];
                    $compenso = $row["compenso"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Aggiorna Record</h2>
                    <p>Qui puoi aggiornare il record e salvare le modifiche apportate.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>Compenso</label>
                            <input type="text" name="compenso" class="form-control <?php echo (!empty($compenso_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $compenso; ?>">
                            <span class="invalid-feedback"><?php echo $compenso_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancella</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>