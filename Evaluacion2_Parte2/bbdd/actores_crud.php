<?php
// incluimos las clases requeridas
require_once '../lib/database.php';
require_once '../classes/actores.php';

/**
 * Clase ActoresCrud para operaciones en la tabla
 */
class ActoresCrud
{
    /**
     * Método para mostrar todos los actores
     */
    public function mostrar()
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todos los actores
        $listaActores = [];
        // realizamos la consulta a la tabla
        $consulta = $db->query("SELECT * FROM actores");

        foreach ($consulta->fetchAll() as $dato) {
            $actor = new Actor($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);
            $listaActores[] = $actor;
        }

        return $listaActores;
    }

    /**
     * Método para obtener un actor
     */
    public function obtener($id)
    {
        $db = Database::conectar();
        // realizamos la búsqueda en la tabla
        $consulta = $db->prepare("SELECT * FROM actores WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de búsqueda
        $consulta->execute();

        $dato = $consulta->fetch();
        $actor = new Actor($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);

        return $actor;
    }

    /**
     * Método para insertar un actor nuevo
     */
    public function insertar($actor)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("INSERT INTO actores VALUES (:id, :nombre, :anyoNacimiento, :pais)");
        // pasamos el objeto actor
        $consulta->bindValue(':id', $actor->getId());
        $consulta->bindValue(':nombre', $actor->getNombre());
        $consulta->bindValue(':anyoNacimiento', $actor->getAnyoNacimiento());
        $consulta->bindValue(':pais', $actor->getPais());
        // ejecutamos la consulta de inserción
        $consulta->execute();
    }

    /**
     * Método para actualizar datos de un actor
     */
    public function actualizar($actor)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("UPDATE actores SET nombre=:nombre, anyoNacimiento=:anyoNacimiento, pais=:pais WHERE id=:id");
        // pasamos el objeto película
        $consulta->bindValue(':nombre', $actor->getNombre());
        $consulta->bindValue(':anyoNacimiento', $actor->getAnyoNacimiento());
        $consulta->bindValue(':pais', $actor->getPais());
        $consulta->bindValue(':id', $actor->getId());
        // ejecutamos la actualización de datos
        $consulta->execute();
    }

    /**
     * Método para eliminar un actor
     */
    public function eliminar($id)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("DELETE FROM actores WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $consulta->execute();
    }
}

// comprobación del código
$actoresCrud = new ActoresCrud();

// test bucar()
// $actor = $actoresCrud->obtener(13);
// echo "ID: {$actor->getId()}<br/>";
// echo "Nombre: {$actor->getNombre()}<br/>";
// echo "Año nacimiento: {$actor->getAnyoNacimiento()}<br/>";
// echo "País: {$actor->getPais()}<br/>";
// echo "<br/>";

// test insertar()
// $newActor = new Actor(null, "Chiquito de la Calzada", 1949, "España");
// $actoresCrud->insertar($newActor);

// test actualizar()
// $actor = $actoresCrud->obtener(13);
// $actor->setPais("Chiquitolandia");
// $actoresCrud->actualizar($actor);

// test eliminar()
//$actoresCrud->eliminar(13);

// test mostrar()
// $actores = $actoresCrud->mostrar();
// foreach ($actores as $actor) {
//     echo "ID: {$actor->getId()}<br/>";
//     echo "Nombre: {$actor->getNombre()}<br/>";
//     echo "Año nacimiento: {$actor->getAnyoNacimiento()}<br/>";
//     echo "País: {$actor->getPais()}<br/>";
//     echo "<br/>";
// }
