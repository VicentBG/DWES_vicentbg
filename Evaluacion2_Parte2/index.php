<?php
// inicializamos los valores
$user = '';
$pass = '';
$check = '';
// comprobamos si existe la cookie
if (isset($_COOKIE['user'])) {
    $datos = unserialize($_COOKIE['user']);
    $user = $datos[0];
    $pass = $datos[1];
    $check = $datos[2] ? 'checked' : '';
}
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
            <a href="./peliculas.php" class="btn btn-dark">Listar películas</a>
        </div>
        <div class="container">
            <div class="row">
                <img class="col" src="./imgs/portada.png"/>
                <div class="col">
                <?php
                // incluimos el CRUD de usuarios y lo instanciamos
                require "./bbdd/usuarios_crud.php";
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
                            <input type='password' class='form-control' name='password' value='$pass' maxlength=50 required>
                        </div>
                        <div class='form-check'>
                            <input type='checkbox' class='form-check-input' name='guardaCredenciales' $check>
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
                            $usuario->setGuardaCredenciales(1);
                            $usuariosCrud->actualizar($usuario);
                            $datos[0] = $usuario->getEmail();
                            $datos[1] = $usuario->getPassword();
                            $datos[2] = $usuario->getGuardaCredenciales();
                            setcookie('user', serialize($datos), time() + (3600 + 24));
                        } else {
                            $usuario->setGuardaCredenciales(0);
                            $usuariosCrud->actualizar($usuario);
                            setcookie('user', '', time() - (3600 + 24));
                        }
                        // iniciamos la sesión y le asignamos el email del usuario
                        session_name("login");
                        session_start();
                        $_SESSION['user'] = $usuario->getEmail();
                        // guardamos fechas y hora de acceso
                        $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
                        // redireccionamos a la página de películas
                        header('Location: peliculas.php');
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