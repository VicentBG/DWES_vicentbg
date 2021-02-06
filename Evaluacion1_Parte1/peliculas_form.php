<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
    crossorigin="anonymous">
    <title>Edición de películas</title>
</head>

<body>
  <div class="container">
    <h1>Edición de películas</h1>
    <!-- INCLUIR CÓDIGO PHP -->
    <?php
    include "./lib/utils.php";
    $pelis = lista('peliculas');
    $id = $_GET['peli'];
    $peli = $pelis[$id];
    // Formulario para modificar datos de las pelis. Se incluyen algunos controles de datos en los inputs
    echo "
          <form action='peliculas_edicion.php?' name='peliculas_edicion'>
            <div class='form-group'>
              <input type='hidden' name='id' value='$id'>
              <label for='titulo'>Título:</label>
              <input type='text' class='form-control' name='nombre' value='$peli[nombre]' maxlength=50 required>
              <small id='tituloHelp' class='form-text text-muted'>Máximo 50 carateres.</small>
            </div>
            <div class='form-group'>
              <label for='ano'>Año:</label>
              <input type='number' class='form-control' name='ano' value='$peli[ano]' max=2020 min=1895 required>
              <small id='tituloHelp' class='form-text text-muted'>Año en que se realizó la película.</small>
            </div>
            <div class='form-group'>
              <label for='duracion'>Duración:</label>
              <input type='number' class='form-control' name='dato' value='$peli[dato]' max=240 min=1 required>
              <small id='tituloHelp' class='form-text text-muted'>Tiempo en minutos.</small>
            </div>
            <button type='submit' class='btn btn-primary'>Guardar</button>
          </form>
    ";
    ?>

</body>

</html>