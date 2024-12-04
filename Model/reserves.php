<?php
require_once 'connexio.php';

function consultarReserves(){
    global $connexio;
    $preparacio = $connexio->prepare("SELECT * FROM Reserves;");
    $preparacio->execute();
    return $preparacio->fetchAll();
}

function consultarReserva($id_reserva){
    global $connexio;
    $preparacio = $connexio->prepare("SELECT * FROM Reserves WHERE id_reserva = $id_reserva;");
    $preparacio->execute();
    return $preparacio->fetch();
}

function inserirReserva($data_reserva, $continent, $pais, $preu, $imatge_url, $nom_client, $telefon_client, $num_persones, $descompte, $total) {
    global $connexio;
    $preparacio = $connexio->prepare(
        "INSERT INTO Reserves (data_reserva, continent, pais, preu, imatge_url, nom_client, telefon_client, num_persones, descompte, total) 
        VALUES (:data_reserva, :continent, :pais, :preu, :imatge_url, :nom_client, :telefon_client, :num_persones, :descompte, :total);"
    );
    $preparacio->execute([
        ':data_reserva' => $data_reserva, // El formato debe ser 'YYYY-MM-DD'
        ':continent' => $continent,
        ':pais' => $pais,
        ':preu' => $preu,
        ':imatge_url' => $imatge_url,
        ':nom_client' => $nom_client,
        ':telefon_client' => $telefon_client,
        ':num_persones' => $num_persones,
        ':descompte' => $descompte,
        ':total' => $total,
    ]);
}

function inserirReservaHistorics($data_reserva, $continent, $pais, $preu, $imatge_url, $nom_client, $telefon_client, $num_persones, $descompte, $total) {
    global $connexio;
    $preparacio = $connexio->prepare(
        "INSERT INTO Historics (data_reserva, continent, pais, preu, imatge_url, nom_client, telefon_client, num_persones, descompte, total)
        VALUES (:data_reserva, :continent, :pais, :preu, :imatge_url, :nom_client, :telefon_client, :num_persones, :descompte, :total);"
    );
    $preparacio->execute([
        ':data_reserva' => $data_reserva,
        ':continent' => $continent,
        ':pais' => $pais,
        ':preu' => $preu,
        ':imatge_url' => $imatge_url,
        ':nom_client' => $nom_client,
        ':telefon_client' => $telefon_client,
        ':num_persones' => $num_persones,
        ':descompte' => $descompte,
        ':total' => $total,
    ]);
}


function eliminarReserva($id_reserva){
    global $connexio;
    $preparacio = $connexio->prepare("DELETE FROM Reserves WHERE id_reserva=:id_reserva;");
    $preparacio->execute([':id_reserva' => $id_reserva]);
}

function obtenirReservesPaginades($offset, $rpp){
    global $connexio;
    $preparacio = $connexio->prepare("SELECT * FROM Reserves ORDER BY data_reserva ASC LIMIT :limit OFFSET :offset;");
    $preparacio->bindValue(':limit', $rpp, PDO::PARAM_INT);
    $preparacio->bindValue(':offset', $offset, PDO::PARAM_INT);
    $preparacio->execute();
    return $preparacio->fetchAll();
}

function obtenirReservesPaginadesPais($offset, $rpp){
    global $connexio;
    $preparacio = $connexio->prepare("SELECT * FROM Reserves ORDER BY pais ASC LIMIT :limit OFFSET :offset;");
    $preparacio->bindValue(':limit', $rpp, PDO::PARAM_INT);
    $preparacio->bindValue(':offset', $offset, PDO::PARAM_INT);
    $preparacio->execute();
    return $preparacio->fetchAll();
}

function obtenirTotalReserves(){
    global $connexio;
    return $connexio->query("SELECT COUNT(*) FROM Reserves")->fetchColumn();
}


function obtenirTotalArticlesUsuari($userID){
    global $connexio;
    return $connexio->query("SELECT COUNT(*) FROM Reserves WHERE User_ID=$userID")->fetchColumn();
}

?>