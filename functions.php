<?php

function eliminaEstensione() {

    $estensioni = ['.php'.'html','.htm','.pdf','.PHP','.HTML','HTM','.PDF'];

   
    }

function eliminaCarattere($stringa){
        
        return substr($stringa, 0, strlen($stringa)-4);
         
}

//echo eliminaCarattere('pippo');




function stampaTitolo() {

    $title = $_SERVER['PHP_SELF'];
    $sub = explode('/', $title);
    $finale = count($sub);
    foreach($sub as $key=>$value) {
         if ( 0 === --$finale) {
           
              $stringa = ucwords($value); 
              echo eliminaCarattere($stringa);
                
             } 
        }
    }


    function Test() {

        echo "sono un test";
    }


  





?>