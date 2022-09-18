<?php 
include('./include/header_site.php');
 ?>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Dettaglio Collaboratori</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Aggiungi Dipendente</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../include/config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Indirizzo</th>";
                                        echo "<th>citta</th>";
                                        echo "<th>Azione</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" ."<b>€</b> " . $row['rating'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="Vedi Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Elimina Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
                <div class="footer-img"><img src="./imgs/collaboratori.jpg"></div>
            </div>        
        </div>
    </div>
</body>
</html>