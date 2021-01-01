<?php
/**
 * Clase Usuarios para instanciar y usar en el CRUD
 */
class Usuarios
{
    // propiedades
    private $id;
    private $email;
    private $password;
    private $guardaCredenciales;

    /**
     * Constructor de la clase
     */
    public function __construct($id, $email, $password, $guardaCredenciales)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->guardaCredenciales = $guardaCredenciales;
    }

    /**
     * Funciones getters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function getGuardaCredenciales()
    {
        return $this->guardaCredenciales;
    }
}