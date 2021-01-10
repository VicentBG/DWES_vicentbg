<?php
// comprobamos que exista la sesión o lo enviamos de vuelta al index
session_name("login");
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
} else {
    // calculamos el tiempo transcurrido
    $antes = $_SESSION['ultimoAcceso'];
    $ahora = date('Y-n-j H:i:s');
    $tiempo_pasado = (strtotime($ahora)-strtotime($antes));
    // comprobamos cuánto tiempo ha pasado
    if ($tiempo_pasado >= 300) {
        // si pasaron más de 5 minutos destruimos sesión y al index de vuelta
        session_destroy();
        header('Location: index.php');
    } else {
        //sino, actualizo la fecha de la sesión
        $_SESSION['ultimoAcceso'] = $ahora;
    }
}
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Película</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="alert alert-secondary d-flex justify-content-between">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>
        <a href="./peliculas.php?logout=si" class="btn btn-dark">Logout</a>
    </div>
    <div class="container">
    <?php
    // si pulsamos logout destruimos sesión y mandamos a index
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
    // Incluimos el CRUD de películas y la instanciamos
    require "./bbdd/peliculas_crud.php";
    $peliculasCrud = new PeliculasCrud();
    // llamamos al método mostrar para obtener la lista de pelis
    $pelis = $peliculasCrud->mostrar();
    print "<div class='card-group'>";
    foreach ($pelis as $peli) {
        $id = $peli->getId();
        $titulo = $peli->getTitulo();
        echo "
        <div class='card'>
            <a href='./peliculas_ficha.php?peli=$id' class='custom-card'>
                <img class='card-img-top' src='./imgs/peliculas/$id.jpg' alt='Card image cap'>
            </a>
            <div class='card-body'>
            <h5 class='card-title'>$titulo</h5>
            <a href='./peliculas_form.php?peli=$id' class='btn btn-primary custom-card'>Editar</a>
            <a href='peliculas.php?peli=$id' class='btn btn-danger custom-card'>Borrar</a>
            </div>
        </div>
        ";
    }
    print "</div>";
    if (isset($_GET['peli'])) {
        if ($peliculasCrud->eliminar($_GET['peli'])) {
            echo "<br/>
            <div class='alert alert-success' role='alert'>
                La película ha sido borrada correctamente.
            </div>
            ";
            $_GET['peli'] = null;
            header('Refresh: 3; url=peliculas.php');
        } else {
            echo "<br/>
            <div class='alert alert-warning' role='alert'>
                Error, ha habido un problema al borrar la película. Inténtelo de nuevo más tarde.
            </div>
            ";
            $_GET['peli'] = null;
            header('Refresh: 3; url=peliculas.php');
        }
    }
    ?>
    </div>
</body>

</html>