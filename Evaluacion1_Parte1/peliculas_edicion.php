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
    <title>Película guardada</title>
</head>

<body>
    <!-- INCLUIR CÓDIGO PHP -->
    <?php
    include "./lib/utils.php";
    // Con los nuevos datos pasados, se modifica la peli
    $datos = array($_GET['id'],$_GET['nombre'],$_GET['ano'],$_GET['dato']);
    editar_pelicula($datos);
    echo "
    <div class='alert alert-success' role='alert'>
      <h3>La película ha sido modificada con éxito</h3>
    </div>
    <a href='./peliculas.php' class='ml-3 h3'>Volver al inicio</a>
    ";
    ?>
</body>

</html>