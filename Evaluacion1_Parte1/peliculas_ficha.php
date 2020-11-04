<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Películas | Ficha</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="alert alert-secondary d-flex">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>&nbsp;&nbsp;
    </div>
    <div class="container">
      <!-- INCLUIR CÓDIGO PHP -->
      <?php
      include "./lib/utils.php";
      $pelis = lista('peliculas');
      $dires = lista('directores');
      $actores = lista('actores');
      $id = $_GET['peli'];
      $peli = $pelis[$id];
      $dires_rel = getDirectores($id, $dires);
      $actores_rel = getActores($id, $actores);
      echo "
          <ul class='list-group'>
            <li class='list-group-item'>
              <strong>Título: </strong>".$peli['nombre']."
            </li>
            <li class='list-group-item'>
              <strong>Año: </strong>".$peli['ano']."
            </li>
            <li class='list-group-item'>
              <strong>Duración: </strong>".$peli['dato']."
            </li>
            <li class='list-group-item'>
              <strong>Director/es: </strong>
              <ul class='list-group'>
      ";
      foreach ($dires_rel as $dir) {
          echo "<li class='list-group-item'>
          <a href='./directores_ficha.php?director=".$dir."'>".$dires[$dir]['nombre']."</a>
          </li>";
      }
      echo "
              </ul>
            </li>
            <li class='list-group-item'>
              <strong>Actor/es: </strong>
              <ul class='list-group'>
      ";
      foreach ($actores_rel as $act) {
          echo "<li class='list-group-item'>
          <a href='./actores_ficha.php?actor=".$act."'>".$actores[$act]['nombre']."</a>
          </li>";
      }
      echo "
              </ul>
            </li>
          </ul>
      ";
      ?>
    </div>
</body>

</html>