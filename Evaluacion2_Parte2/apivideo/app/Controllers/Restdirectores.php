<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\DirectorModel;

class Restdirectores extends ResourceController
{
     protected $modelName = 'App\Models\DirectorModel';
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
        $directores = array();
        foreach ($data as $row) {
            $director = array(
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "anyoNacimiento" => $row['anyoNacimiento'],
                "pais" => $row['pais'],
                "links" => array(
                    array("rel" => "self","href" => $this->url("/restdirectores/".$row['id']),"action" => "GET", "types" =>["text/xml","application/json"]),
                    array("rel" => "self","href" => $this->url("/restdirectores/".$row['id']), "action"=>"PUT", "types" => ["application/x-www-form-urlencoded"]),
                    array("rel" => "self","href" => $this->url("/restdirectores/".$row['id']), "action"=>"DELETE", "types"=> [] )
                )
               
            );
            array_push($directores, $director);
        }
        return $directores;
    }

    // OPERACIONES TIPO GET: devuelve todos o un director (por id)
    public function index()
    {
        $data = $this->model->getAll();
        $directores = $this->map($data);
       
        return $this->genericResponse($directores, null, 200);
    }
 
    public function show($id = null)
    {
        $data = $this->model->get($id);      
        $director = $this->map($data); 

        return $this->genericResponse($director, null, 200);
    }

    // OPERACIONES TIPO POST: crea un nuevo director
    public function create()
    {
        $directores = new DirectorModel();
 
        if ($this->validate('directores')) {
            $id = $directores->insert(
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
        $directores = new DirectorModel();

        // Al ser un método de tipo PUT o PATCH debemos recoger los datos usando el método getRawInput
        $data = $this->request->getRawInput();
 
        if ($this->validate('directores')) {
 
            if (!$directores->get($id)) {
                return $this->genericResponse(null, array("id" => "El director no existe"), 500);
            }
 
            $directores->update(
                $id,
                [
                "id" => $data['id'],
                "nombre" => $data['nombre'],
                "anyoNacimiento" => $data['anyoNacimiento'],
                "pais" => $data['pais']
                ]
            );
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }

    }

    // OPERACIONES DELETE: borrado de un recurso
    public function delete($id = null)
    {
        $directores = new DirectorModel();
        $directores->delete($id);
 
        return $this->genericResponse("Director borrado", null, 200);
    }
}
