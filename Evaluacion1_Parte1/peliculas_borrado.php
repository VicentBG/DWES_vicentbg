<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
    <title>Borrar película</title>
</head>
<body>
<div class="alert alert-success" role="alert">
    <!-- INCLUIR CÓDIGO PHP -->
    <?php
    include "./lib/utils.php";
    // Se recupera el dato de id de la peli y se pasa a la función de borrado
    $id = $_GET['peli'];
    borrar_pelicula($id);
    print "<h3>La película ha sido borrada con éxito</h3>";
    ?>
</div>
    <!-- INCLUIR CÓDIGO PHP -->
    <?php
    print "<a href='./peliculas.php' class='ml-3 h3'>Volver al inicio</a>";
    ?>
</body>
</html>