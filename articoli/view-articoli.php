<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../include/config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM articoli WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $categoria = $row["categoria"];
                $articolo = $row["articolo"];
                $descrizione = $row["descrizione"];
                $qta = $row["qta"];
                $prezzo = $row["prezzo"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">Visualizza Articoli</h1>
                    <div class="form-group">
                        <label>Categoria</label>
                        <p><b><?php echo $row["categoria"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Articolo</label>
                        <p><b><?php echo $row["articolo"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Descrizione</label>
                        <p><b><?php echo $row["descrizione"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Quantità</label>
                        <p><b><?php echo $row["qta"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Prezzo</label>
                        <p><b><?php echo $row["prezzo"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Ritorna indietro</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>