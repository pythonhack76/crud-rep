<?php
// Include config file
require_once "../include/config.php";
 
// Define variables and initialize with empty values
$categoria = $articolo = $descrizione = $qta = $prezzo = "";
$categoria_err = $articolo_err = $descrizione_err = $qta_err = $prezzo_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){



      // Validate descrizione
      $input_categoria = trim($_POST["categoria"]);
      if(empty($input_categoria)){
          $categoria_err = "Si prega di inserire una categoria.";     
      } else{
          $categoria = $input_categoria;
      }

    // Validazione articolo 
    $input_articolo = trim($_POST["articolo"]);
    if(empty($input_articolo)){
        $articolo_err = "Si prega di inserire un nome articolo.";
    } elseif(!filter_var($input_articolo, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $articolo_err = "SI prega di inserire un nome articolo valido.";
    } else{
        $articolo = $input_articolo;
    }
    
    // Validate descrizione
    $input_descrizione = trim($_POST["descrizione"]);
    if(empty($input_descrizione)){
        $descrizione_err = "Si prega di inserire una descrizione.";     
    } else{
        $descrizione = $input_descrizione;
    }

      // Validazione qta
      $input_qta = trim($_POST["qta"]);
      if(empty($input_qta)){
          $qta_err = "Si prega di inserire una quantità.";     
      } elseif(!ctype_digit($input_qta)){
          $qta_err = "Si prega di inserire un valore intero positivo.";
      } else{
          $qta = $input_qta;
      }


    
    // Validazione prezzo
    $input_prezzo = trim($_POST["prezzo"]);
    if(empty($input_prezzo)){
        $prezzo_err = "Si prega di inserire un prezzo.";     
    } elseif(!ctype_digit($input_prezzo)){
        $prezzo_err = "Si prega di inserire un valore intero positivo.";
    } else{
        $prezzo = $input_prezzo;
    }
    
    // Check input errors before inserting in database
    if(empty($categoria_err) && empty($articolo_err) && empty($descrizione_err) && empty($qta_err) && empty($prezzo_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO articoli (categoria, articolo, descrizione, qta, prezzo) VALUES (:categoria, :articolo, 
        :descrizione, :qta, :prezzo)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":categoria", $param_categoria);
            $stmt->bindParam(":articolo", $param_articolo);
            $stmt->bindParam(":descrizione", $param_descrizione);
            $stmt->bindParam(":qta", $param_qta);
            $stmt->bindParam(":prezzo", $param_prezzo);
            
            // Set parameters
            $param_categoria = $categoria;
            $param_articolo = $articolo;
            $param_descrizione = $descrizione;
            $param_qta = $qta;
            $param_prezzo = $prezzo;
            
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
<?php include ('header-articoli.php'); ?>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Inserisci Nuovo Articolo</h2>
                    <p>Per favore compila tutti i campi per aggiungere un nuovo articolo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" name="categoria" class="form-control <?php echo (!empty($categoria_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categoria; ?>">
                            <span class="invalid-feedback"><?php echo $categoria_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Articolo</label>
                            <input type="text" name="articolo" class="form-control <?php echo (!empty($articolo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $articolo; ?>">
                            <span class="invalid-feedback"><?php echo $articolo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Descrizione</label>
                            <textarea name="descrizione" class="form-control <?php echo (!empty($descrizione_err)) ? 'is-invalid' : ''; ?>"><?php echo $descrizione; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descrizione_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantità</label>
                            <input type="text" name="qta" class="form-control <?php echo (!empty($qta_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $qta; ?>">
                            <span class="invalid-feedback"><?php echo $qta_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prezzo</label>
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
    <div class="footer-img">
        <img src="./imgs/articoli-smart.jpg">
    </div>
</body>
</html>