<?php

function TitlePage(){

    $link = $_SERVER['REQUEST_URI'];
        $explode_link = explode("/", $link);
        // $_ultimo = $explode_link[0];
        // echo $_ultimo; 

        $toEnd  = count($explode_link);
        foreach($explode_link as $key=>$value){
           if ( 0 === --$toEnd) {
            echo substr($value,0,-4);
                }
           }

        }





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

    // function Calendario() {
        // $mese = date('m');
        // $anno = date('Y');
        // $giorni = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
        // echo $giorni;
    // }


    function manageAdmin(){
        $superAdmin = 'lrulvoni@gmail.com';
        $admin = ''; 
        
    }


?>