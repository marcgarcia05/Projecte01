<?php
include 'mostrar.php';
session_start();
//Controlem si la sessió esta iniciada, i controlem la pagina
    if (isset($_GET['page'])){
        $paginaActual = (int)$_GET['page'];
        if($paginaActual == 0){
            $paginaActual = 1;
        }
    } else{

        $paginaActual = 1;
    }
    if (isset($_GET['order'])){
        $ordre = $_GET['order'];
    } else{
        $ordre = "data";
    }
    echo $ordre;
    echo $paginaActual;
    mostrar($paginaActual, $ordre);
?>


