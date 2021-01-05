<?php
// comprobamos que exista la sesión o lo enviamos de vuelta al index
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Películas | Ficha</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="alert alert-secondary d-flex">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>&nbsp;&nbsp;
    </div>
    <div class="container">
    <?php
    // Incluimos el CRUD de películas y la instanciamos
    require "./bbdd/peliculas_crud.php";
    $peliculasCrud = new PeliculasCrud();
    // Se recuperan los diferentes datos para mostrar según la id de la peli
    $id = $_GET['peli'];
    $peli = $peliculasCrud->obtener($id);
    $dires = $peliculasCrud->obtenerDirectoresPelicula($id);
    $actores = $peliculasCrud->obtenerActoresPelicula($id);
    echo "
        <ul class='list-group'>
            <li class='list-group-item'>
            <strong>Título: </strong>{$peli->getTitulo()}
            </li>
            <li class='list-group-item'>
            <strong>Año: </strong>{$peli->getAnyo()}
            </li>
            <li class='list-group-item'>
            <strong>Duración: </strong>{$peli->getDuracion()}
            </li>
            <li class='list-group-item'>
            <strong>Director/es: </strong>
            <ul class='list-group'>
    ";
    foreach ($dires as $dir) {
        echo "<li class='list-group-item'>
        <a href='./directores_ficha.php?director={$dir->getId()}'>{$dir->getNombre()}</a>
        </li>";
    }
    echo "
            </ul>
            </li>
            <li class='list-group-item'>
            <strong>Actor/es: </strong>
            <ul class='list-group'>
    ";
    foreach ($actores as $act) {
        echo "<li class='list-group-item'>
        <a href='./actores_ficha.php?actor={$act->getId()}'>{$act->getNombre()}</a>
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