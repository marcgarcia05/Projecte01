<?php
require_once '../Model/reserves.php';

//Guardem el contingut introduït per l'usuari
$data = date('Y-m-d', strtotime($_POST['data']));
$continent = $_POST['continent'];
$pais = $_POST['pais'];
$preu = $_POST['preu'];
$nom = $_POST['nom'];
$telefon = $_POST['telefon'];
$persones = $_POST['persones'];
$total = $_POST['total'];
if (isset($_POST['descompte'])) {
    $descompte = 1;
} else {
    $descompte = 0;
}

//Evitem code injection
$data = htmlspecialchars($data);
$continent = htmlspecialchars($continent);
$pais = htmlspecialchars($pais);
$nom = htmlspecialchars($nom);
$telefon = htmlspecialchars($telefon);
$persones = htmlspecialchars($persones);


//Generem una llista buida on guardarem els diferents errors de l'usuari
$errors = [];

//Comprovem que el nom no està buit
if (empty($nom)) {
    array_push($errors, "ERROR - NOM NO POT ESTAR BUIT!!");
}
//Comprovem que el text no està buit
if (empty($telefon)) {
    array_push($errors, "ERROR - TELEFON NO POT ESTAR BUIT!!");
} elseif (!preg_match("/^[0-9]{9,15}$/", $telefon)){
    array_push($errors, "ERROR - NUMERO DE TELEFON INCORRECTE!!");
}
if (empty($data)) {
    array_push($errors, "ERROR - DATA NO POT ESTAR BUIT!!");
}
if (empty($persones)) {
    array_push($errors, "ERROR - PERSONES NO POT ESTAR BUIT!!");
} elseif (!preg_match("/^[0-9]$/", $persones)){
    array_push($errors, "ERROR - PERSONES HA DE SER UN NUMERO!!");
}


//En cas de no tenir cap error, afegim les dades a la BBDD
if (empty($errors)) {
    inserirReserva($data, $continent, ucfirst(strtolower($pais)), $preu, "../IMG/" . netejarString($pais) . ".jpeg", $nom, $telefon, $persones, $descompte, $total);
    inserirReservaHistorics($data, $continent, ucfirst(strtolower($pais)), $preu, "../IMG/" . netejarString($pais) . ".jpeg", $nom, $telefon, $persones, $descompte, $total);
    //Mostrem el missatge
    $missatge = "<div class='alertes alert alert-success d-flex align-items-center' role='alert'>RESERVA INTRODUIDA CORRECTAMENT!!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></div>";
    session_start();
    $_SESSION['missatge'] = $missatge;
    header("Location: ../Vistes/index.view.php?page=1");
    exit();
} else {
    //Mostrem els errors
    $missatge = tractarErrors($errors);
    mostrarMissatge($missatge);
}


function tractarErrors($errors) {
    $missatge = "<br><div class='alertes'>";
    foreach ($errors as $error) {
        $missatge .= "<div class='alerta alert alert-danger d-flex align-items-center' role='alert'>$error<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></div>";
    }
    $missatge .= "</div>";
    return $missatge;
}

function mostrarMissatge($missatge) {
    session_start();
    $_SESSION['missatge'] = $missatge;
    header("Location: ../Vistes/index.view.php?page=1");
}

function netejarString($str) {
    $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    return preg_replace('/[^a-zA-Z0-9\s]/', '', $str);
}


?>