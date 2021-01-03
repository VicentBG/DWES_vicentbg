<?php
// incluimos las clases requeridas
require_once '../lib/database.php';
require_once '../classes/peliculas.php';
require_once '../classes/actores.php';
require_once '../classes/directores.php';

/**
 * Clase PeliculasCrud para operaciones en la tabla
 */
class PeliculasCrud
{
    /**
     * Método para mostrar todas las películas
     */
    public function mostrar()
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todas las pelis
        $listaPelis = [];
        // realizamos la consulta a la tabla
        $consulta = $db->query("SELECT * FROM peliculas");

        foreach ($consulta->fetchAll() as $dato) {
            $peli = new Pelicula($dato['id'], $dato['titulo'], $dato['anyo'], $dato['duracion']);
            $listaPelis[] = $peli;
        }

        return $listaPelis;
    }

    /**
     * Método para obtener una película
     */
    public function obtener($id)
    {
        $db = Database::conectar();
        // realizamos la búsqueda en la tabla
        $consulta = $db->prepare("SELECT * FROM peliculas WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de búsqueda
        $consulta->execute();

        $dato = $consulta->fetch();
        $peli = new Pelicula($dato['id'], $dato['titulo'], $dato['anyo'], $dato['duracion']);

        return $peli;
    }

    /**
     * Método para insertar una película nueva
     */
    public function insertar($peli)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("INSERT INTO peliculas VALUES (:id, :titulo, :anyo, :duracion)");
        // pasamos el objeto película
        $consulta->bindValue(':id', $peli->getId());
        $consulta->bindValue(':titulo', $peli->getTitulo());
        $consulta->bindValue(':anyo', $peli->getAnyo());
        $consulta->bindValue(':duracion', $peli->getDuracion());
        // ejecutamos la consulta de inserción
        $consulta->execute();
    }

    /**
     * Método para actualizar datos de una película
     */
    public function actualizar($peli)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("UPDATE peliculas SET titulo=:titulo, anyo=:anyo, duracion=:duracion WHERE id=:id");
        // pasamos el objeto película
        $consulta->bindValue(':titulo', $peli->getTitulo());
        $consulta->bindValue(':anyo', $peli->getAnyo());
        $consulta->bindValue(':duracion', $peli->getDuracion());
        $consulta->bindValue(':id', $peli->getId());
        // ejecutamos la actualización de datos
        $consulta->execute();
    }

    /**
     * Método para eliminar una película
     */
    public function eliminar($id)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $consulta = $db->prepare("DELETE FROM peliculas WHERE id=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $consulta->execute();
    }

    /**
     * Método para obtener los actores de una peli
     */
    public function obtenerActoresPelicula($id)
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todas los actores
        $listaActores = [];
        // preparamos la consulta a la tabla
        $consulta = $db->prepare("SELECT * FROM actores a INNER JOIN peliculas_actores p ON a.id=p.id_actor WHERE p.id_pelicula=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $consulta->execute();

        foreach ($consulta->fetchAll() as $dato) {
            $actor = new Actor($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);
            $listaActores[] = $actor;
        }

        return $listaActores;
    }

    /**
     * Método para obtener los directores de una peli
     */
    public function obtenerDirectoresPelicula($id)
    {
        $db = Database::conectar();
        // inicializamos lista para guardar todas los actores
        $listaDirectores = [];
        // preparamos la consulta a la tabla
        $consulta = $db->prepare("SELECT * FROM directores d INNER JOIN peliculas_directores p ON d.id=p.id_director WHERE p.id_pelicula=:id");
        // pasamos el id
        $consulta->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $consulta->execute();

        foreach ($consulta->fetchAll() as $dato) {
            $director = new Director($dato['id'], $dato['nombre'], $dato['anyoNacimiento'], $dato['pais']);
            $listaDirectores[] = $director;
        }

        return $listaDirectores;
    }
}

// comprobación del código
$peliculasCrud = new PeliculasCrud();

// test obtener()
// $peli = $peliculasCrud->obtener(6);
// echo "ID: {$peli->getId()}<br/>";
// echo "Título: {$peli->getTitulo()}<br/>";
// echo "Año: {$peli->getAnyo()}<br/>";
// echo "Duración: {$peli->getDuracion()}<br/>";
// echo "<br/>";

// test insertar()
// $newPeli = new Pelicula(null, "Fiebre del sábado noche", 1977, 119);
// $peliculasCrud->insertar($newPeli);

// test actualizar()
// $peli = $peliculasCrud->obtener(5);
// $peli->setTitulo('Fiebrita del covid noche');
// $peliculasCrud->actualizar($peli);

// test eliminar()
//$peliculasCrud->eliminar(7);

// test mostrar()
// $pelis = $peliculasCrud->mostrar();
// foreach ($pelis as $peli) {
//     echo "ID: {$peli->getId()}<br/>";
//     echo "Título: {$peli->getTitulo()}<br/>";
//     echo "Año: {$peli->getAnyo()}<br/>";
//     echo "Duración: {$peli->getDuracion()}<br/>";
//     echo "<br/>";
// }

// test obtenerActoresPelicula()
// $actores = $peliculasCrud->obtenerActoresPelicula(1);
// foreach ($actores as $actor) {
//     echo "ID: {$actor->getId()}<br/>";
//     echo "Nombre: {$actor->getNombre()}<br/>";
//     echo "Año nacimiento: {$actor->getAnyoNacimiento()}<br/>";
//     echo "País: {$actor->getPais()}<br/>";
//     echo "<br/>";

    // test obtenerDirectoresPelicula()
// $directores = $peliculasCrud->obtenerDirectoresPelicula(4);
// foreach ($directores as $director) {
//     echo "ID: {$director->getId()}<br/>";
//     echo "Nombre: {$director->getNombre()}<br/>";
//     echo "Año nacimiento: {$director->getAnyoNacimiento()}<br/>";
//     echo "País: {$director->getPais()}<br/>";
//     echo "<br/>";
// }
