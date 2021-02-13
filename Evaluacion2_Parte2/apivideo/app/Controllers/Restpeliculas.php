<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PeliculaModel;
use App\Models\DirectorModel;
use App\Models\ActorModel;
use App\Models\PeliculaDirectorModel;
use App\Models\PeliculaActorModel;

class Restpeliculas extends ResourceController
{
     protected $modelName = 'App\Models\PeliculaModel';
     protected $format = 'json';

    /**
     * Función que devuelve el estado de la petición, si error muestra mensaje
     */
    private function genericResponse($data, $msj, $code)
    {

        if ($code == 200) {
            return $this->respond(
                array(
                "data" => $data,
                "code" => $code
                )
            );
        } else {
            return $this->respond(
                array(
                "msj" => $msj,
                "code" => $code
                )
            );
        }
    }

    /**
     * Función donde obtenemos el base_url
     */
    private function url($segmento)
    {
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $segmento;
    }

    /**
     * Función que construye los datos
     */
    private function map($data)
    {
        $directores = new DirectorModel();
        $actores = new ActorModel();
        $peliculas = array();
        $d_links = array();
        $a_links = array();
        foreach ($data as $row) {
            $pelicula = array(
                "id" => $row['id'],
                "titulo" => $row['titulo'],
                "anyo" => $row['anyo'],
                "duracion" => $row['duracion'],
                "links" => array(
                    array("rel" => "self","href" => $this->url("/restpeliculas/".$row['id']),"action" => "GET", "types" =>["text/xml","application/json"]),
                    array("rel" => "self","href" => $this->url("/restpeliculas/".$row['id']), "action"=>"PUT", "types" => ["application/x-www-form-urlencoded"]),
                    array("rel" => "self","href" => $this->url("/restpeliculas/".$row['id']), "action"=>"DELETE", "types"=> [] )
                )
               
            );
            $d_links = $directores->getOnly($row['id']);
            foreach ($d_links as $director) {
                $director_links = array(
                    "id" => $director['id'],
                    "nombre" => $director['nombre'],
                    "anyoNacimiento" => $director['anyoNacimiento'],
                    "pais" => $director['pais'],
                    "links" => array(
                        array("rel" => "director","href" => $this->url("/restdirectores/".$director['id']),"action" => "GET", "types" =>["text/xml","application/json"]),
                        array("rel" => "director","href" => $this->url("/restdirectores/".$director['id']), "action"=>"PUT", "types" => ["application/x-www-form-urlencoded"]),
                        array("rel" => "director","href" => $this->url("/restdirectores/".$director['id']), "action"=>"DELETE", "types"=> [] )
                    )
                );
                $pelicula['directores'][] = $director_links;
            }
            $a_links = $actores->getOnly($row['id']);
            foreach ($a_links as $actor) {
                $actor_links = array(
                    "id" => $actor['id'],
                    "nombre" => $actor['nombre'],
                    "anyoNacimiento" => $actor['anyoNacimiento'],
                    "pais" => $actor['pais'],
                    "links" => array(
                        array("rel" => "actor","href" => $this->url("/restactores/".$actor['id']),"action" => "GET", "types" =>["text/xml","application/json"]),
                        array("rel" => "actor","href" => $this->url("/restactores/".$actor['id']), "action"=>"PUT", "types" => ["application/x-www-form-urlencoded"]),
                        array("rel" => "actor","href" => $this->url("/restactores/".$actor['id']), "action"=>"DELETE", "types"=> [] )
                    )
                );
                $pelicula['actores'][] = $actor_links;
            }
            array_push($peliculas, $pelicula);
        }
        return $peliculas;
    }

    // OPERACIONES TIPO GET: devuelve todas o una película (por id)
    public function index()
    {
        $data = $this->model->getAll();
        $peliculas = $this->map($data);
       
        return $this->genericResponse($peliculas, null, 200);
    }
 
    public function show($id = null)
    {
        $data = $this->model->get($id);      
        $pelicula = $this->map($data); 

        return $this->genericResponse($pelicula, null, 200);
    }

    // OPERACIONES TIPO POST: crea una nueva película
    public function create()
    {
        $peliculas = new PeliculaModel();
        $directores = new DirectorModel();
        $actores = new ActorModel();
        $peliDirector = new PeliculaDirectorModel();
        $peliActor = new PeliculaActorModel();
 
        if ($this->validate('peliculas')) {
            $dir = $this->request->getPost('id_director');
            for ($i=0;$i<$this->request->getPost('numActores');$i++) {
                $act[$i] = $this->request->getPost('id_actor['.$i.']');
            }
            if (!$directores->get($dir)) {
                return $this->genericResponse(null, 'El director '. $dir .' no existe en la BBDD!', 500);
            }
            foreach ($act as $a) {
                if (!$actores->get($a)) {
                    return $this->genericResponse(null, 'El actor '. $a .' no existe en la BBDD!', 500);
                }
            }
            $id = $peliculas->insert(
                [
                    'titulo' => $this->request->getPost('titulo'),
                    'anyo' => $this->request->getPost('anyo'),
                    'duracion' => $this->request->getPost('duracion')
                ]
            );
            $peliDirector->insert(
                [
                    'id_pelicula' => $id,
                    'id_director' => $dir
                ]
            );
            foreach ($act as $a) {
                $peliActor->insert(
                    [
                        'id_pelicula' => $id,
                        'id_actor' => $a
                    ]
                );
            }

            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        //Hemos creado validaciones en el archivo de configuración Validation.php
        $validation = \Config\Services::validation();
        //Si no pasa la validación devolvemos un error 500
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }


    // OPERACIONES TIPO PUT O PATCH: actualización de un recurso
    public function update($id = null)
    {
        $peliculas = new PeliculaModel();

        // Al ser un método de tipo PUT o PATCH debemos recoger los datos usando el método getRawInput
        $data = $this->request->getRawInput();
 
        if ($this->validate('peliculas')) {
 
            if (!$peliculas->get($id)) {
                return $this->genericResponse(null, array("id" => "La película no existe"), 500);
            }
 
            $peliculas->update(
                $id,
                [
                "titulo" => $data['titulo'],
                "anyo" => $data['anyo'],
                "duracion" => $data['duracion']
                ]
            );
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }

    }

    // OPERACIONES DELETE: borrado de un recurso
    public function delete($id = null)
    {
        $peliculas = new PeliculaModel();
        $peliculas->delete($id);
 
        return $this->genericResponse("Película borrada", null, 200);
    }
}
