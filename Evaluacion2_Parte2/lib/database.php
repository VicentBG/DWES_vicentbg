<?php
/**
 * Clase Database para gestionar las conexiones a la bd
 */
class Database
{
    // datos conexión base de datos mysql
    private static $dbHost = "localhost";
    private static $dbBD = "videoclub";
    private static $dbUser = "alumno";
    private static $dbPass = "alumno";

    // variable conexión
    private static $conn = null;

    /**
     * Método conexión
     */
    public static function conectar()
    {
        // comprobamos éxito de la conexión
        try {
            self::$conn = new PDO("mysql:host=".self::$dbHost.";dbname=".self::$dbBD, self::$dbUser, self::$dbPass);
        } catch (PDOException $e) {
            // si falla indicamos mensaje de error
            die($e->getMessage());
        }
        // retornamos la conexión establecida
        return self::$conn;
    }

    /**
     * Método desconexión
     */
    public static function desconectar()
    {
        // ponemos la conexión a null
        self::$conn = null;
    }
}