<?php
require_once '../Model/reserves.php';

function mostrar($paginaActual, $ordre){
    session_start();
    // Registre per pagina
    $rpp = 3;

    $totalArticulos = obtenirTotalReserves();
    $totalPaginas = ceil($totalArticulos / $rpp);
    // Si la pàgina que ens han passat és més gran que l'última pàgina que tenim disponible mostrarem la pàgina 1
    if ($paginaActual > $totalPaginas) {
        $paginaActual = 1;
    }

    $offset = ($paginaActual - 1) * $rpp;
    if ($ordre == "pais") {
        $resultats = obtenirReservesPaginadesPais($offset, $rpp);
        $_SESSION['order'] = "pais";
    } elseif ($ordre == "data") {
        $resultats = obtenirReservesPaginades($offset, $rpp);
        $_SESSION['order'] = "data";
    } else {
        $resultats = obtenirReservesPaginades($offset, $rpp);
    }

    // Comprovem que hi ha productes
    if (count($resultats) > 0) {
        $missatge = "<div class='container text-center position-flex'>\n<div class='row row-cols-3 mx-auto'>\n";
        // Generem els productes
        foreach ($resultats as $row) {
            $missatge .= "<div class='col mt-3'><div class='card' style='width: 18rem;'>\n<div class='card-body'>\n";
            $data = DateTime::createFromFormat('Y-m-d', $row['data_reserva']);
            // Obtener el día, mes y año
            $dia = $data->format('d');
            $mes = $data->format('m');
            $any = $data->format('Y');
            $dataOk = $dia . '-' . $mes . '-' . $any;
            // Mostrar los campos en el orden solicitado
            $missatge .= "<strong>Data:</strong> " . $dataOk . "<br>";
            $missatge .= "<strong>País:</strong> " . $row['pais'] . "<br>";
            $missatge .= "<strong>Nom persona:</strong> " . $row['nom_client'] . "<br>";
            $missatge .= "<strong>Telèfon:</strong> " . $row['telefon_client'] . "<br>";
            $missatge .= "<strong>Num persones:</strong> " . $row['num_persones'] . "<br>";
            $missatge .= "<strong>Preu total:</strong> " . $row['total'] . "€<br><br>";
            $missatge .= "<img src='" . $row['imatge_url'] . "' alt='Foto reserva' style='width: 100%; height: auto; border-radius: 15px;'>\n";

            $missatge .= "<form method='post' action='../Controlador/eliminar.php'><button formAction='../Controlador/eliminar.php' type='submit' name='eliminar' value='" . $row['id_reserva'] . "' class='btn btn-danger mt-2 mx-1'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/></svg></button></form>\n";

            $missatge .= "</div>\n</div>\n</div>\n";
        }
        $missatge .= "</div>\n</div>";

        // Paginació
        $paginacio = "";
        // Boto enrere
        $enrere = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-caret-left-fill' viewBox='0 0 16 16'>
                    <path d='m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z'/></svg>";
        // Boto següent
        $seguent = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-caret-right-fill' viewBox='0 0 16 16'>
                    <path d='m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z'/></svg>";
        // Mostrem fletxa enrere
        if ($paginaActual > 1) {
            $paginacio .= "<li class='page-item'>\n<a class='page-link' href=?page=" . ($paginaActual - 1) . ">". $enrere ."</a>\n</li>";
        } else {
            $paginacio .= "<li class='page-item disabled'>\n<a class='page-link'>". $enrere ."</a>\n</li>";
        }
        // Generem els "botons" de les pàgines
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == $paginaActual) {
                $paginacio .= "<li class='page-item active' aria-current='page'>
                                    <a class='page-link' href='?page=$i'>$i</a></li>";
            } else {
                $paginacio .= "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
        }

        // Mostrem fletxa endavant
        if ($paginaActual < $totalPaginas) {
            $paginacio .= "<li class='page-item'>\n<a class='page-link' href=?page=" . ($paginaActual + 1) . ">". $seguent ."</a>\n</li>";
        } else {
            $paginacio .= "<li class='page-item disabled'>\n<a class='page-link'>". $seguent ."</a>\n</li>";
        }

        // Passem la taula a la Vista
        $_SESSION['reserves'] = $missatge;
        $_SESSION['paginacio'] = $paginacio;
        header("Location: ../Vistes/index.view.php?page=" . $paginaActual);
    } else {
        // Passem la taula a la Vista
        $_SESSION['articles'] = "<p>No tens cap producte disponible</p>";
        header("Location: ../Vistes/index.view.php?page=" . $paginaActual);
    }

    header("Location: ../Vistes/index.view.php?page=$paginaActual");
}
?>