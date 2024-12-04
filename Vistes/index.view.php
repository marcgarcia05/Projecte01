<?php
session_start();
$paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if (!isset($_SESSION['reserves'])) {
  header("Location: ../Controlador/index.php?page=" . $paginaActual);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wonderfull travels</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../Estils/alertes.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color: #e0ffff;">
  <div class="container fons"></div>
  <div class="position-absolute top-0 start-100 translate-middle">
    <?php
    require_once 'index.html';
    ?>
  </div>

  <h1 class='display-3 text-center mt-3'>Wonderfull Travels</h1>


  <form class="mx-5" method="POST" action="../Controlador/inserir.php">
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="inputdata4">Data</label>
        <input type="date" class="form-control" id="data" name="data" value="<?php echo date('Y-m-d'); ?>" placeholder="data">
      </div>
      <div class="row">
      </div>
      <label for="inputdesti4">Destí</label>
      <div class="row g-3 position-relative">
        <div class="col-md-2">
          <select id="continent" name="continent" class="form-control">
            <option selected>Europa</option>
            <option>America</option>
            <option>Asia</option>
            <option>Africa</option>
          </select>
        </div>
        <div class="col-md-2">
          <select id="pais" name="pais" class="form-control">
            <option selected>...</option>
          </select>
        </div>
        <div class="col-md-2 position-absolute top-0 translate-middle-x mx-4" style="left: 40%;">
          <img id="imagenPais" src="" alt="Imagen del país" class="img-fluid" style="width: 200px; height: auto;">
        </div>
      </div>
      <label for="inputpreu">Preu</label>
      <div class="row g-2 position-relative">
        <div class="col-md-2">
          <input type="text" class="form-control" id="preu" name="preu" readonly>
        </div>
        <div class="col-md-2">
          <label for="inputpreu" class="mt-1">€</label>
        </div>
      </div>
      <div class="form-group col-md-2">
        <label for="inputnom2">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom">
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label for="inputtelefon">Telèfon</label>
          <input type="text" class="form-control" id="telefon" name="telefon">
        </div>
        <div class="form-group col-md-1">
          <label for="inputpersones">Persones</label>
          <input type="text" class="form-control" id="persones" name="persones">
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="descompte" name="descompte">
          <label class="form-check-label" for="gridCheck">
            Descompte 20%
          </label>
        </div>
      </div>
      <label for="inpuTotal">Total</label>
      <div class="row g-2 position-relative">
        <div class="col-md-2">
          <input type="text" class="form-control" id="total" name="total" readonly>
        </div>
        <div class="col-md-2">
          <label for="inputTotal" class="mt-1">€</label>
        </div>
      </div>
      <input type="submit" class="btn btn-primary mt-1" value="Afegir">
  </form>
  <div class="d-flex justify-content-end">
    <!-- Dropup -->
    <div class="btn-group">
      <button type="button" class="btn btn-warning dropdown-toggle ml-auto" data-bs-toggle="dropdown" aria-expanded="false">Order By</button>
      <ul class="dropdown-menu">
        <?php
        if (isset($_SESSION['order'])) {
          if ($_SESSION['order'] == "data") {
            echo "<li><a class='dropdown-item active' href='../Controlador/index.php?order=data'>Data</a></li>";
            echo "<li><a class='dropdown-item' href='../Controlador/index.php?order=pais'>Pais</a></li>";
          } elseif ($_SESSION['order'] == "pais") {
            echo "<li><a class='dropdown-item' href='../Controlador/index.php?order=data'>Data</a></li>";
            echo "<li><a class='dropdown-item active' href='../Controlador/index.php?order=pais'>Pais</a></li>";
          } 
        } else {
          echo "<li><a class='dropdown-item active' href='../Controlador/index.php?order=data'>Data</a></li>";
          echo "<li><a class='dropdown-item' href='../Controlador/index.php?order=pais'>Pais</a></li>";
        }
        ?>
      </ul>
    </div>

  </div>
  <div class="mt-3 text-center">
    <?php
    //Mostrem els articles
    if (isset($_SESSION['reserves'])) {
      echo $_SESSION['reserves'];
      unset($_SESSION['reserves']);
    }
    //Mostrem missatges
    if (isset($_SESSION['missatge'])) {
      echo $_SESSION['missatge'];
      unset($_SESSION['missatge']);
    }
    ?>
  </div>
  <div class="mt-3">
    <nav>
      <ul class="pagination justify-content-center">
        <?php
        //Mostrem paginació
        if (isset($_SESSION['paginacio'])) {
          echo $_SESSION['paginacio'];
          unset($_SESSION['paginacio']);
        }
        ?>
      </ul>
    </nav>


    <!-- Enlace a Bootstrap JS (necesario para el desplegable) -->


  </div>
  <script src="../JavaScript/pais60.js?v=1.0"></script>
</body>

</html>