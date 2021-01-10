<?php
// incluimos las clases requeridas
require_once './lib/database.php';
require_once './classes/directores.php';

/**
 * Clase DirectoresCrud para operaciones en la tabla
 */
class DirectoresCrud
{
    /**
     * Método para mostrar todos los directores
     */
    public function mostrar()
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todos los directores
        $listaDirectores = [];
        // realizamos la consulta a la tabla
        $consulta = $db->query("SELECT * FROM directores");

        foreach ($consulta->fetchAll() as $dato) {
            $director = new Director($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);
            $listaDirectores[] = $director;
        }

        return $listaDirectores;
    }

    /**
     * Método para obtener un director
     */
    public function obtener($id)
    {
        $db = Database::conectar();
        // realizamos la búsqueda en la tabla
        $consulta = $db->prepare("SELECT * FROM directores WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de búsqueda
        $consulta->execute();

        $dato = $consulta->fetch();
        if ($dato) {
            $director = new Director($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);
        } else {
            $director = null;
        }

        return $director;
    }

    /**
     * Método para insertar un director nuevo
     */
    public function insertar($director)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("INSERT INTO directores VALUES (:id, :nombre, :anyoNacimiento, :pais)");
        // pasamos el objeto actor
        $consulta->bindValue(':id', $director->getId());
        $consulta->bindValue(':nombre', $director->getNombre());
        $consulta->bindValue(':anyoNacimiento', $director->getAnyoNacimiento());
        $consulta->bindValue(':pais', $director->getPais());
        // ejecutamos la consulta de inserción
        $consulta->execute();
    }

    /**
     * Método para actualizar datos de un director
     */
    public function actualizar($director)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("UPDATE directores SET nombre=:nombre, anyoNacimiento=:anyoNacimiento, pais=:pais WHERE id=:id");
        // pasamos el objeto director
        $consulta->bindValue(':nombre', $director->getNombre());
        $consulta->bindValue(':anyoNacimiento', $director->getAnyoNacimiento());
        $consulta->bindValue(':pais', $director->getPais());
        $consulta->bindValue(':id', $director->getId());
        // ejecutamos la actualización de datos
        $consulta->execute();
    }

    /**
     * Método para eliminar un director
     */
    public function eliminar($id)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("DELETE FROM directores WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        if ($consulta->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

// comprobación del código
// $directoresCrud = new DirectoresCrud();

// test obtener()
// $director = $directoresCrud->obtener(4);
// echo "ID: {$director->getId()}<br/>";
// echo "Nombre: {$director->getNombre()}<br/>";
// echo "Año nacimiento: {$director->getAnyoNacimiento()}<br/>";
// echo "País: {$director->getPais()}<br/>";
// echo "<br/>";

// test insertar()
// $newDirector = new Director(null, "Chiquito de la Calzada", 1949, "España");
// $directoresCrud->insertar($newDirector);

// test actualizar()
// $director = $directoresCrud->obtener(4);
// $director->setPais("Chiquitolandia");
// $directoresCrud->actualizar($director);

// test eliminar()
// $directoresCrud->eliminar(4);

// test mostrar()
// $directores = $directoresCrud->mostrar();
// foreach ($directores as $director) {
//     echo "ID: {$director->getId()}<br/>";
//     echo "Nombre: {$director->getNombre()}<br/>";
//     echo "Año nacimiento: {$director->getAnyoNacimiento()}<br/>";
//     echo "País: {$director->getPais()}<br/>";
//     echo "<br/>";
// }
