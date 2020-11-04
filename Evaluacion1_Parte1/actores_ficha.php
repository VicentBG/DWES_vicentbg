<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Directores | Ficha</title>
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
        $actores = lista('actores');
        $id = $_GET['actor'];
        echo "
          <ul class='list-group'>
            <li class='list-group-item'>
              <strong>Nombre: </strong>".$actores[$id]['nombre']."
            </li>
            <li class='list-group-item'>
              <strong>Año: </strong>".$actores[$id]['ano']."
            </li>
            <li class='list-group-item'>
              <strong>País: </strong>".$actores[$id]['dato']."
            </li>
          </ul>
        ";
        ?>
    </div>
</body>

</html>