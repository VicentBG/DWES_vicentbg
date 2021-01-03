<?php
// comprobamos si existe la cookie
$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : "";
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Gestión de películas</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">    
    </head>
    <body>
        <div class="alert alert-secondary d-flex">
            <a href="./peliculas.php" class="btn btn-dark">Listar películas</a>&nbsp;&nbsp;
        </div>
        <div class="container">
            <div class="row">
                <img class="col" src="./imgs/portada.png"/>
                <div class="col">
                <?php
                include "./bbdd/usuarios_crud.php";
                $usuariosCrud = new UsuariosCrud();
                // Formulario para comprobar datos del usuario. Se incluyen algunos controles de datos en los inputs.
                // Si existe la cookie, metemos su valor en el formulario.
                echo "
                    <form action='' name='user'>
                        <div class='form-group'>
                            <label for='email'>Email:</label>
                            <input type='text' class='form-control' name='email' value='$user' placeholder='Introduce email' maxlength=50 required>
                        </div>
                        <div class='form-group'>
                            <label for='password'>Contraseña:</label>
                            <input type='password' class='form-control' name='password' maxlength=50 required>
                        </div>
                        <div class='form-check'>
                            <input type='checkbox' class='form-check-input' name='guardaCredenciales'>
                            <label class='form-check-label' for='guardaCredenciales'>Guarda mis credenciales</label>
                        </div>
                        <button type='submit' class='btn btn-primary'>Acceder</button>
                    </form>
                    <br/>
                ";
                if (isset($_GET['email']) && isset($_GET['password'])) {
                    // consultamos en la bd por el usuario introducido
                    $usuario = $usuariosCrud->obtener($_GET['email']);
                    // comprobamos que existe y que el password coincide
                    if ($usuario != null && $usuario->getPassword() == $_GET['password']) {
                        echo "<div class='text-success'>USUARIO CORRECTO</div>";
                        // creamos la cookie si el checkbox está marcado
                        if (isset($_GET['guardaCredenciales'])) {
                            setcookie('user', $usuario->getEmail(), time() + (3600 + 24));
                        }
                        // iniciamos la sesión y le asignamos el email del usuario
                        session_start();
                        $_SESSION['user'] = $usuario->getEmail();
                    } else {
                        echo "<div class='text-danger'>USUARIO NO EXISTE O CONTRASEÑA INCORRECTA</div>";
                    }
                }
                ?>
                </div>
            </div>
        </div> 
    </body>
</html>