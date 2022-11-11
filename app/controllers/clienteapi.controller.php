<?php
require_once './app/models/cliente_model.php';
require_once './app/views/api.view.php';

class ClienteApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new ClienteModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getAllClient($params = null) {
        $client = $this->model->getAllClient();
        $this->view->response($client);

        $columns= ['id', 'nombre', 'apellido', 'dni'];
        
        //order asc y desc
        if (isset($_GET['sort']) && isset ($_GET['order'])){
            
            $sort= $_GET['sort'];
            $order= $_GET['order'];

            //$columnsexist= (mb_strtolower($sort) == $columns[0] || mb_strtolower($sort) == $columns[1] || mb_strtolower($sort) == $columns[2] || mb_strtolower($sort) == $columns[3]);
            //pregunta si sort esta dentro de columns 
            $columnsexist= in_array($sort, $columns);
            if(mb_strtolower($order) != 'asc' && mb_strtolower($order) !='desc' || !$columnsexist){ 
                $this->view->response("La columna $sort o el ordenamiento $order no existe. Las columnas disponibles son $columns[0], $columns[1], $columns[2], $columns[3]");
            }
            else{
                $this->model->getClientOrder($sort,$order);
                $this->view->response($client);
            }
        }
    }
    

    public function getClient($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $client = $this->model->getClient($id);

        // si no existe devuelvo 404
        if ($client)
            $this->view->response($client);
        else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

    public function insertClient($params = null) {
        $client = $this->getData();

        if (empty($client->nombre) || empty($client->apellido) || empty($client->dni)) 
            $this->view->response("Complete los datos", 400);
        else {
            $id = $this->model->insertClient($client->nombre, $client->apellido, $client->dni);
            $cliente = $this->model->getClient($id);
            $this->view->response($cliente, 201);
        }
    }

    public function editClient($params = null){
        $id = $params[':ID'];

        $client = $this->getData();

        if ($id) {
            $this->model->editClient($id, $client->nombre, $client->apellido, $client->dni);
            $this->view->response("El cliente con id=$id fue modificado con exito", 200);
        } else {
            $this->view->response("El cliente con el id=$id no existe", 404);
        }

    }

    public function deleteClient($params = null) {
        $id = $params[':ID'];
        $client = $this->model->getClient($id);

        if ($client) {
            $this->model->deleteClient($id);
            $this->view->response("El cliente con id=$id fue eliminado con exito", 200);
        } else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

}