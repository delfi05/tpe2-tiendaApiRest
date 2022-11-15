<?php
require_once './app/models/client_model.php';
require_once './app/views/api.view.php';

class ClientApiController{
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new ClientModel();
        $this->view = new ApiView();
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    public function getAllClient($params = null){ 
        
        //filtrado por nombre
        if(!empty($_GET['filtername'])){
            $code['filter']= -1;
            $filtername = mb_strtolower($_GET['filtername']);
        }else{
            $filtername = null;
        }

        //ordenado asc y desc
        if(!empty($_GET['sort']) && (!empty($_GET['order']))){
            $sort = ($_GET['sort']);
            $order = ($_GET['order']);

            if ($this->model->validateFieldOrder($sort, $order) != 0){
                return $this->view->response("El campo de orden o el tipo de orden son invalidos",400);
            }    
        }else{
            $sort = null;
            $order = null;
        }

        //paginado
        if(!empty($_GET['page']) && (!empty($_GET['limit']))){
            $code['paginated']= -4;
            $page = intval($_GET['page']);
            $limit = intval($_GET['limit']);
            $offset = ($limit * $page) - $limit;
            if(($page<=0) || ($limit<=0) || (!is_numeric($page)) || (!is_numeric($limit))){
                return $this->view->response("La pagina y el limite tienen que se un numero que sea mayor a cero",400); 
            }
        }else{
            $offset = null;
            $limit = null;
        }
        
        $result = $this->model->getAllClient($filtername, $sort, $order, $limit, $offset);
        if(count($result)>0){
            $this->view->response($result, 200);
        }else{
            $this->view->response("No se encontro usuario con ese nombre o ese numero de pagina",404);
        }
    }

    public function getClient($params = null){
        $id = $params[':ID'];
        $client = $this->model->getClient($id);

        // si no existe devuelvo 404
        if($client)
            $this->view->response($client, 200);
        else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }

    public function insertClient($params = null){
        $client = $this->getData();

        if(!empty($client->nombre) && !empty($client->apellido) && !empty($client->dni)){
            $id = $this->model->insertClient($client->nombre, $client->apellido, $client->dni);
            $cliente = $this->model->getClient($id);
            $this->view->response($cliente, 201);
        }else{
            $this->view->response("Hay campos que se encuentran incompletos", 400); 
        }
    }

    public function editClient($params = null){
        $id = $params[':ID'];
        $client = $this->getData();
        $clientid = $this->model->getclient($id);
        
        if($clientid){
            $this->model->editClient($id, $client->nombre, $client->apellido, $client->dni);
            $this->view->response("El cliente con id=$id fue modificado con exito", 200);
        }else{
            $this->view->response("El cliente con el id=$id no existe", 404);
        }
    }

    public function deleteClient($params = null){
        $id = $params[':ID'];
        $client = $this->model->getClient($id);

        if($client){
            $this->model->deleteClient($id);
            $this->view->response("El cliente con id=$id fue eliminado con exito", 200);
        }else 
            $this->view->response("El cliente con el id=$id no existe", 404);
    }
}
