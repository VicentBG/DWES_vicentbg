<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class PeliculaModel extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'anyo', 'duracion'];

    
    /**
     * Obtenemos todas las películas
     */
    public function getAll()
    {
        $query = $this->query("SELECT * FROM peliculas");
        return $query->getResult('array');
    }

    /**
     * Obtenemos una única película
     */
    public function get($id)
    {     
        $sql = "SELECT * FROM peliculas WHERE id=:id:";
        $query = $this->query(
            $sql,
            ['id' => $id]
        );    
        return $query->getResult('array');
    }
}
