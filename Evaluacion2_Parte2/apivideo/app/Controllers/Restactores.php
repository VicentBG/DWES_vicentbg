<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ActorModel;

class Restactores extends ResourceController
{
     protected $modelName = 'App\Models\ActorModel';
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
        $actores = array();
        foreach ($data as $row) {
            $actor = array(
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "anyoNacimiento" => $row['anyoNacimiento'],
                "pais" => $row['pais'],
                "links" => array(
                    array("rel" => "self","href" => $this->url("/restactores/".$row['id']),"action" => "GET", "types" =>["text/xml","application/json"]),
                    array("rel" => "self","href" => $this->url("/restactores/".$row['id']), "action"=>"PUT", "types" => ["application/x-www-form-urlencoded"]),
                    array("rel" => "self","href" => $this->url("/restactores/".$row['id']), "action"=>"PATCH" ,"types" => ["application/x-www-form-urlencoded"]),
                    array("rel" => "self","href" => $this->url("/restactores/".$row['id']), "action"=>"DELETE", "types"=> [] )
                )
               
            );
            array_push($actores, $actor);
        }
        return $actores;
    }

    // OPERACIONES TIPO GET: devuelve todos o un actor (por id)
    public function index()
    {
        $data = $this->model->getAll();
        $actores = $this->map($data);
       
        return $this->genericResponse($actores, null, 200);
    }
 
    public function show($id = null)
    {
        $data = $this->model->get($id);      
        $actor = $this->map($data); 

        return $this->genericResponse($actor, null, 200);
    }

    // OPERACIONES TIPO POST: crea un nuevo actor
    public function create()
    {
        $actores = new ActorModel();
 
        if ($this->validate('actores')) {
            $id = $actores->insert(
                [
                'nombre' => $this->request->getPost('nombre'),
                'anyoNacimiento' => $this->request->getPost('anyoNacimiento'),
                'pais' => $this->request->getPost('pais')
                ]
            );

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
        $actores = new ActorModel();

        // Al ser un método de tipo PUT o PATCH debemos recoger los datos usando el método getRawInput
        $data = $this->request->getRawInput();
 
        if ($this->validate('actores')) {
 
            if (!$actores->get($id)) {
                return $this->genericResponse(null, array("id" => "El actor no existe"), 500);
            }
 
            $actores->update(
                $id,
                [
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "anyoNacimiento" => $row['anyoNacimiento'],
                "pais" => $row['pais']
                ]
            );
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }

    }

    // OPERACIONES DELETE: borrado de un recurso
    public function delete($id = null)
    {
        $actores = new ActorModel();
        $actores->delete($id);
 
        return $this->genericResponse("Actor borrado", null, 200);
    }
}
