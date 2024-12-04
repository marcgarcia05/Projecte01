<?php
//Parametres per realitzar la connexio amb la BBDD
$dbHost="localhost";
$dbNom="wonderfull_travels";
$dbUsuari="root";
$dbPassword="";
//Ens connectem
try {
    $connexio=new PDO("mysql:host=$dbHost;dbname=$dbNom", $dbUsuari, $dbPassword);
    $connexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
//En cas d'error el mostrem
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>