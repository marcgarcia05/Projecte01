<?php
include 'mostrar.php';
session_start();
if (consultarReserva($_POST['eliminar'])){
    eliminarReserva($_POST['eliminar']);
}
header("Location: ../Vistes/index.view.php");
?>


