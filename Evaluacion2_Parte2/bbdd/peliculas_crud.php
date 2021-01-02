<?php
// incluimos las clases requeridas
require_once '../lib/database.php';
require_once '../classes/peliculas.php';

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
     * Método para buscar una película
     */
    public function buscar($id)
    {
        $db = Database::conectar();
        // realizamos la búsqueda en la tabla
        $busca = $db->prepare("SELECT * FROM peliculas WHERE id=:id");
        // pasamos el id
        $busca->bindValue(':id', $id);
        // ejecutamos la consulta de búsqueda
        $busca->execute();

        $dato = $busca->fetch();
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
        $insertar = $db->prepare("INSERT INTO peliculas VALUES (:id, :titulo, :anyo, :duracion)");
        // pasamos el objeto película
        $insertar->bindValue(':id', $peli->getId());
        $insertar->bindValue(':titulo', $peli->getTitulo());
        $insertar->bindValue(':anyo', $peli->getAnyo());
        $insertar->bindValue(':duracion', $peli->getDuracion());
        // ejecutamos la consulta de inserción
        $insertar->execute();
    }

    /**
     * Método para actualizar datos de una película
     */
    public function actualizar($peli)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $actualizar = $db->prepare("UPDATE peliculas SET titulo=:titulo, anyo=:anyo, duracion=:duracion WHERE id=:id");
        // pasamos el objeto película
        $actualizar->bindValue(':titulo', $peli->getTitulo());
        $actualizar->bindValue(':anyo', $peli->getAnyo());
        $actualizar->bindValue(':duracion', $peli->getDuracion());
        $actualizar->bindValue(':id', $peli->getId());
        // ejecutamos la actualización de datos
        $actualizar->execute();
    }

    /**
     * Método para borrar una película
     */
    public function borrar($id)
    {
        $db = Database::conectar();
        // preparamos la consulta
        $borrar = $db->prepare("DELETE FROM peliculas WHERE id=:id");
        // pasamos el id
        $borrar->bindValue(':id', $id);
        // ejecutamos la consulta de borrado
        $borrar->execute();
    }
}

// comprobación del código
$peliculasCrud = new PeliculasCrud();

// test bucar()
$peli = $peliculasCrud->buscar(6);
echo "ID: {$peli->getId()}<br/>";
echo "Título: {$peli->getTitulo()}<br/>";
echo "Año: {$peli->getAnyo()}<br/>";
echo "Duración: {$peli->getDuracion()}<br/>";
echo "<br/>";

// test insertar()
//$newPeli = new Pelicula(null, "Fiebre del sábado noche", "1977", "119");
//$peliculasCrud->insertar($newPeli);

// test actualizar()
// $peli = $peliculasCrud->buscar(5);
// $peli->setTitulo('Fiebrita del covid noche');
// $peliculasCrud->actualizar($peli);

// test borrar()
$peliculasCrud->borrar(6);

// test mostrar()
$pelis = $peliculasCrud->mostrar();
foreach ($pelis as $peli) {
    echo "ID: {$peli->getId()}<br/>";
    echo "Título: {$peli->getTitulo()}<br/>";
    echo "Año: {$peli->getAnyo()}<br/>";
    echo "Duración: {$peli->getDuracion()}<br/>";
    echo "<br/>";
}