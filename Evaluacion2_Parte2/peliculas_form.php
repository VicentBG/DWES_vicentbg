<?php
// comprobamos que exista la sesión o lo enviamos de vuelta al index
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
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
    <title>Edición de películas</title>
</head>

<body>
    <div class="alert alert-secondary d-flex">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>&nbsp;&nbsp;
    </div>
    <div class="container">
    <h1>Edición de películas</h1>
    <?php
    require "./bbdd/peliculas_crud.php";
    $peliculasCrud = new PeliculasCrud();
    $id = $_GET['peli'];
    // llamamos al método para obtener los datos de la peli
    $peli = $peliculasCrud->obtener($id);
    // si hemos pulsado el botón de actualizar, modificamos los datos
    if (isset($_GET['actualizar'])) {
        $peli->setTitulo($_GET['titulo']);
        $peli->setAnyo($_GET['anyo']);
        $peli->setDuracion($_GET['duracion']);
        if ($peliculasCrud->actualizar($peli)) {
            echo "<br/>
            <div class='alert alert-success' role='alert'>
                La película ha sido actualizada correctamente.
            </div>
            ";
            $_GET['actualizar'] = null;
        } else {
            echo "<br/>
            <div class='alert alert-warning' role='alert'>
                Error, ha habido un problema al actualizar la película. Inténtelo de nuevo más tarde.
            </div>
            ";
            $_GET['actualizar'] = null;
        }
    }
    // Formulario para modificar datos de las pelis. Se incluyen algunos controles de datos en los inputs
    echo "
          <form action='' name='peliculas_edicion'>
            <div class='form-group'>
              <input type='hidden' name='peli' value='$id'>
              <input type='hidden' name='actualizar' value='ok'>
              <label for='titulo'>Título:</label>
              <input type='text' class='form-control' name='titulo' value='{$peli->getTitulo()}' maxlength=50 required>
              <small id='tituloHelp' class='form-text text-muted'>Máximo 50 carateres.</small>
            </div>
            <div class='form-group'>
              <label for='ano'>Año:</label>
              <input type='number' class='form-control' name='anyo' value='{$peli->getAnyo()}' max=2020 min=1895 required>
              <small id='tituloHelp' class='form-text text-muted'>Año en que se realizó la película.</small>
            </div>
            <div class='form-group'>
              <label for='duracion'>Duración:</label>
              <input type='number' class='form-control' name='duracion' value='{$peli->getDuracion()}' max=240 min=1 required>
              <small id='tituloHelp' class='form-text text-muted'>Tiempo en minutos.</small>
            </div>
            <button type='submit' class='btn btn-primary'>Guardar</button>
          </form>
    ";
    ?>
    </div>

</body>

</html>