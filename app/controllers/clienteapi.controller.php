<?php
require_once './app/models/cliente_model.php';
require_once './app/views/api.view.php';

class TaskApiController {
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

    public function getAllClientes($params = null) {
        $clientes = $this->model->getAllClientes();
        $this->view->response($clientes);
    }

    public function getCliente($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $cliente = $this->model->getCliente($id);

        // si no existe devuelvo 404
        if ($cliente)
            $this->view->response($cliente);
        else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

    public function insertCliente($params = null) {
        $cliente = $this->getData();

        if (empty($cliente->nombre) || empty($cliente->apellido) || empty($cliente->dni)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insertCliente($cliente->nombre, $cliente->apellido, $cliente->dni);
            $cliente = $this->model->getCliente($id);
            $this->view->response($cliente, 201);
        }
    }

    public function editarCliente($params=null){
        $id = $params[':ID'];
        $cliente = $this->getData();

        if ($cliente) {
            $this->model->editarCliente($id, $cliente->nombre, $cliente->apellido, $cliente->dni);
            $this->view->response("El cliente con id=$id fue modificado con exito", 200);
        } else {
            $this->view->response("El cliente con el id=$id no existe", 404);
        }

    }

    public function deleteCliente($params = null) {
        $id = $params[':ID'];

        $cliente = $this->model->getCliente($id);
        if ($cliente) {
            $this->model->deleteCliente($id);
            $this->view->response($cliente);
        } else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

}