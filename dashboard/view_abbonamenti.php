<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Abbonamenti</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Elenco Abbonamenti</h2>
                        <a href="add_abbonamento.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Aggiungi</a> <a href="dashboard.php" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Dashboard</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../include/config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM abbonamenti";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Abbonamento</th>";
                                        echo "<th>descrizione</th>";
                                        echo "<th>prezzo</th>";
                                        echo "<th>stato</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['abbonamentiID'] . "</td>";
                                        echo "<td>" . $row['abbonamento'] . "</td>";
                                        echo "<td>" . $row['descrizione'] . "</td>";
                                        echo "<td>" ."<b>€</b> " . $row['prezzo'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_abbonamento.php?id='. $row['abbonamentiID'] .'" class="mr-3" title="Vedi Dettaglio" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_abbonamento.php?id='. $row['abbonamentiID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_abbonamento.php?id='. $row['abbonamentiID'] .'" title="Elimina Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Nessun record trovato!</em></div>';
                        }
                    } else{
                        echo "Oops! Qualcosa non funziona. Riprova.";
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                </div>
                <div class="footer-img"><img src="./imgs/abbonamenti.jpg"></div>
            </div>        
        </div>
    </div>
</body>
</html>