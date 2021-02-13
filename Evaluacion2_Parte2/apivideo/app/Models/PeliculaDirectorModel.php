<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class PeliculaDirectorModel extends Model
{
    protected $table = 'peliculas_directores';
    protected $primaryKey = 'id_pelicula'.'id_director';
    protected $allowedFields = ['id_pelicula', 'id_director'];

}
