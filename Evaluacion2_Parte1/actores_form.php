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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Edición de actores</title>
</head>

<body>
    <div class="alert alert-secondary d-flex justify-content-between">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>
        <a href="./peliculas.php?logout=si" class="btn btn-dark">Logout</a>
    </div>
    <div class="container">
    <h1>Edición de actores</h1>
    <?php
    // si pulsamos logout destruimos sesión y mandamos a index
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }
    require "./bbdd/actores_crud.php";
    $actoresCrud = new ActoresCrud();
    $id = $_GET['actor'];
    // llamamos al método para obtener los datos del actor
    $actor = $actoresCrud->obtener($id);
    // si hemos pulsado el botón de actualizar, modificamos los datos
    if (isset($_GET['actualizar'])) {
        $actor->setNombre($_GET['nombre']);
        $actor->setAnyoNacimiento($_GET['anyoNacimiento']);
        $actor->setPais($_GET['pais']);
        if ($actoresCrud->actualizar($actor)) {
            echo "<br/>
            <div class='alert alert-success' role='alert'>
                El actor ha sido actualizado correctamente.
            </div>
            ";
            $_GET['actualizar'] = null;
        } else {
            echo "<br/>
            <div class='alert alert-warning' role='alert'>
                Error, ha habido un problema al actualizar el actor. Inténtelo de nuevo más tarde.
            </div>
            ";
            $_GET['actualizar'] = null;
        }
    }
    // Formulario para modificar datos de las pelis. Se incluyen algunos controles de datos en los inputs
    echo "
          <form action='' name='actores_edicion'>
            <div class='form-group'>
              <input type='hidden' name='actor' value='$id'>
              <input type='hidden' name='actualizar' value='ok'>
              <label for='titulo'>Nombre:</label>
              <input type='text' class='form-control' name='nombre' value='{$actor->getNombre()}' maxlength=50 required>
              <small id='tituloHelp' class='form-text text-muted'>Máximo 50 carateres.</small>
            </div>
            <div class='form-group'>
              <label for='ano'>Año nacimiento:</label>
              <input type='number' class='form-control' name='anyoNacimiento' value='{$actor->getAnyoNacimiento()}' max=2020 min=1895 required>
              <small id='tituloHelp' class='form-text text-muted'>Año en que nació el director.</small>
            </div>
            <div class='form-group'>
              <label for='duracion'>País:</label>
              <input type='text' class='form-control' name='pais' value='{$actor->getPais()}' maxlength=50 required>
              <small id='tituloHelp' class='form-text text-muted'>Máximo 50 carateres.</small>
            </div>
            <button type='submit' class='btn btn-primary'>Guardar</button>
          </form>
    ";
    ?>
    </div>

</body>

</html>