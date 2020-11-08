<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Películas</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="alert alert-secondary d-flex">
        <a href="./peliculas.php" class="btn btn-dark">Películas</a>
    </div>
    <div class="container">
        <div class="row mx-auto">
            <!-- INCLUIR CÓDIGO PHP -->
            <?php
            // Incluimos la librería de funciones y preparamos el array de pelis para mostrar
            include "./lib/utils.php";
            $pelis = lista('peliculas');
            print "<div class='card-group'>";
            foreach ($pelis as $key=>$peli) {
                $id = $peli['id'];
                $titulo = $peli['nombre'];
                echo "
                <div class='card'>
                    <a href='./peliculas_ficha.php?peli=$id' class='custom-card'>
                    <img class='card-img-top' src='./imgs/peliculas/$id.jpg' alt='Card image cap'>
                    </a>
                    <div class='card-body'>
                    <h5 class='card-title'>$titulo</h5>
                    <a href='./peliculas_form.php?peli=$id' class='btn btn-primary custom-card'>Editar</a>
                    <a href='./peliculas_borrado.php?peli=$id' class='btn btn-danger custom-card'>Borrar</a>
                    </div>
                </div>
                ";
            }
            print "</div>";
            ?>
        </div>
    </div>
</body>

</html>