<?php
// incluimos las clases requeridas
require_once './lib/database.php';
require_once './classes/usuarios.php';

/**
 * Clase UsuariosCrud para operaciones en la tabla
 */
class UsuariosCrud
{
    /**
     * Método para mostrar todos los usuarios
     */
    public function mostrar()
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todos los usuarios
        $listaUsuarios = [];
        // realizamos la consulta a la tabla
        $consulta = $db->query("SELECT * FROM usuarios");

        foreach ($consulta->fetchAll() as $dato) {
            $usuario = new Usuario($dato['id'], $dato['email'], $dato['password'], $dato['guardaCredenciales']);
            $listaUsuarios[] = $usuario;
        }
        $db = Database::desconectar();
        return $listaUsuarios;
    }

    /**
     * Método para obtener un usuario
     */
    public function obtener($email)
    {
        $db = Database::conectar();
        // realizamos la búsqueda en la tabla
        $consulta = $db->prepare("SELECT * FROM usuarios WHERE email=:email");
        // pasamos el id
        $consulta->bindValue(':email', $email);
        // ejecutamos la consulta de búsqueda
        $consulta->execute();

        $dato = $consulta->fetch();
        if ($dato) {
            $usuario = new Usuario($dato['id'], $dato['email'], $dato['password'], $dato['guardaCredenciales']);
        } else {
            $usuario = null;
        }
        $db = Database::desconectar();
        return $usuario;
    }

    /**
     * Método para insertar un usuario nuevo
     */
    public function insertar($usuario)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("INSERT INTO usuarios VALUES (:id, :email, :password, :guardaCredenciales)");
        // pasamos el objeto usuario
        $consulta->bindValue(':id', $usuario->getId());
        $consulta->bindValue(':email', $usuario->getEmail());
        $consulta->bindValue(':password', $usuario->getPassword());
        $consulta->bindValue(':guardaCredenciales', $usuario->getGuardaCredenciales());
        // ejecutamos la consulta de inserción
        $consulta->execute();
        $db = Database::desconectar();
    }

    /**
     * Método para actualizar datos de un usuario
     */
    public function actualizar($usuario)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("UPDATE usuarios SET email=:email, password=:password, guardaCredenciales=:guardaCredenciales WHERE id=:id");
        // pasamos el objeto director
        $consulta->bindValue(':email', $usuario->getEmail());
        $consulta->bindValue(':password', $usuario->getPassword());
        $consulta->bindValue(':guardaCredenciales', $usuario->getGuardaCredenciales());
        $consulta->bindValue(':id', $usuario->getId());
        // ejecutamos la actualización de datos
        $consulta->execute();
        $db = Database::desconectar();
    }

    /**
     * Método para eliminar un usuario
     */
    public function eliminar($id)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("DELETE FROM usuarios WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $consulta->execute();
        $db = Database::desconectar();
    }
}

// comprobación del código
// $usuariosCrud = new UsuariosCrud();

// test obtener()
// $usuario = $usuariosCrud->obtener('pm');
// echo "ID: {$usuario->getId()}<br/>";
// echo "Email: {$usuario->getEmail()}<br/>";
// echo "Password: {$usuario->getPassword()}<br/>";
// echo "Guarda credenciales?: {$usuario->getGuardaCredenciales()}<br/>";
// echo "<br/>";

// test insertar()
// $newUsuario = new Usuario(null, "mi@email.es", "elquelatienepequeñanolaenseña", true);
// $usuariosCrud->insertar($newUsuario);

// test actualizar()
// $usuario = $usuariosCrud->obtener(2);
// $usuario->setPassword("loquemesaledeltoto");
// $usuariosCrud->actualizar($usuario);

// test eliminar()
// $usuariosCrud->eliminar(2);

// test mostrar()
// $usuarios = $usuariosCrud->mostrar();
// foreach ($usuarios as $usuario) {
//     echo "ID: {$usuario->getId()}<br/>";
//     echo "Email: {$usuario->getEmail()}<br/>";
//     echo "Password: {$usuario->getPassword()}<br/>";
//     echo "Guarda credenciales?: {$usuario->getGuardaCredenciales()}<br/>";
//     echo "<br/>";
// }
