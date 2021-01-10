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
    // Incluimos el CRUD de directores y lo instanciamos
    require "./bbdd/directores_crud.php";
    $directoresCrud = new DirectoresCrud();
    // Se recuperan los diferentes datos para mostrar según la id del director
    if (isset($_GET['director']) && !isset($_GET['borrar'])) {
        $id = $_GET['director'];
        $director = $directoresCrud->obtener($id);
        echo "
            <div class='card'>
                <div class='card-body'>
                <h5 class='card-title'>
                    <ul class='list-group'>
                        <li class='list-group-item'>
                            <strong>Nombre: </strong>{$director->getNombre()}
                        </li>
                        <li class='list-group-item'>
                            <strong>Año: </strong>{$director->getAnyoNacimiento()}
                        </li>
                        <li class='list-group-item'>
                            <strong>País: </strong>{$director->getPais()}
                        </li>
                    </ul>
                </h5>
                <a href='./directores_form.php?director=$id' class='btn btn-primary custom-card'>Editar</a>
                <a href='directores_ficha.php?director=$id&borrar=si' class='btn btn-danger custom-card'>Borrar</a>
                </div>
            </div>
        ";
    } else {
        if ($directoresCrud->eliminar($_GET['director'])) {
            echo "<br/>
            <div class='alert alert-success' role='alert'>
                El director ha sido borrado correctamente.
            </div>
            ";
            $_GET['borrar'] = null;
        } else {
            echo "<br/>
            <div class='alert alert-warning' role='alert'>
                Error, ha habido un problema al borrar el director. Inténtelo de nuevo más tarde.
            </div>
            ";
            $_GET['borrar'] = null;
        }
    }
    ?>
    </div>
</body>

</html>