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
    <title>Directores | Ficha</title>
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
    // Incluimos el CRUD de actores y lo instanciamos
    require "./bbdd/actores_crud.php";
    $actoresCrud = new ActoresCrud();
    // Se recuperan los diferentes datos para mostrar según la id del actor
    $id = $_GET['actor'];
    $actor = $actoresCrud->obtener($id);
    echo "
        <div class='card'>
            <div class='card-body'>
            <h5 class='card-title'>
                <ul class='list-group'>
                    <li class='list-group-item'>
                        <strong>Nombre: </strong>{$actor->getNombre()}
                    </li>
                    <li class='list-group-item'>
                        <strong>Año: </strong>{$actor->getAnyoNacimiento()}
                    </li>
                    <li class='list-group-item'>
                        <strong>País: </strong>{$actor->getPais()}
                    </li>
                </ul>
            </h5>
            <a href='./directores_form.php?actor=$id' class='btn btn-primary custom-card'>Editar</a>
            <a href='' class='btn btn-danger custom-card'>Borrar</a>
            </div>
        </div>
    ";
    ?>
    </div>
</body>

</html>