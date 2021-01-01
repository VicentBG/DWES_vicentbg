<?php
/**
 * Clase Peliculas para instanciar y usar en el CRUD
 */
class Peliculas
{
    // propiedades
    private $id;
    private $titulo;
    private $anyo;
    private $duracion;

    /**
     * Constructor de la clase
     */
    public function __construct($id, $titulo, $anyo, $duracion)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->anyo = $anyo;
        $this->duracion = $duracion;
    }

    /**
     * Funciones getters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getAnyo()
    {
        return $this->anyo;
    }
    
    public function getDuracion()
    {
        return $this->duracion;
    }
}