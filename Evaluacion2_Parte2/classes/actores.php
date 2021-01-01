<?php
/**
 * Clase Actores para instanciar y usar en el CRUD
 */
class Actores
{
    // propiedades
    private $id;
    private $nombre;
    private $anyoNacimiento;
    private $pais;

    /**
     * Constructor de la clase
     */
    public function __construct($id, $nombre, $anyoNacimiento, $pais)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->anyoNacimiento = $anyoNacimiento;
        $this->pais = $pais;
    }

    /**
     * Funciones getters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getAnyoNacimiento()
    {
        return $this->anyoNacimiento;
    }
    
    public function getPais()
    {
        return $this->pais;
    }
}