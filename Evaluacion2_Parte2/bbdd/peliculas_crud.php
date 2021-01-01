<?php
// incluimos las clases requeridas
require_once './lib/database.php';
require_once './classes/peliculas.php';

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
        $db = Database::$conectar();
        // inicializamos lista para guardar todas las pelis
        $listaPelis = [];
        // realizamos la consulta a la tabla
        $consulta = $db->query("SELECT * FROM peliculas");

        foreach ($consultas->fetchAll() as $dato) {
            $peli = new Pelicula($dato['id'], $dato['titulo'], $dato['anyo'], $dato['duracion']);
            $listaPelis[] = $peli;
        }

        return $listaPelis;
    }
}