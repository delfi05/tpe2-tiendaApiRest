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
        $columns= ['id', 'nombre', 'apellido', 'dni'];
        
        //order asc y desc
        if (isset($_GET['sort']) && isset($_GET['order'])){
            $sort=$_GET['sort'];
            $order= $_GET['order'];
            //$columnsexist= (mb_strtolower($sort) == $columns[0] || mb_strtolower($sort) == $columns[1] || mb_strtolower($sort) == $columns[2] || mb_strtolower($sort) == $columns[3]);
            //pregunta si sort esta dentro de columns 
            $columnsexist= in_array($sort, $columns);
            if(((mb_strtolower($order) != 'asc') && (mb_strtolower($order) !='desc')) || !$columnsexist){ 
                $this->view->response("La columna $sort o el ordenamiento $order no existe. Las columnas disponibles son $columns[0], $columns[1], $columns[2], $columns[3]");
            }
            else{
                $ordenado = $this->model->getClientOrder($sort,$order);
                $this->view->response($ordenado);
            }
        }
        //paginacion
        else if (isset($_GET['page']) && isset($_GET['limit'])){
            $page = ($_GET['page']);
            $limit = ($_GET['limit']);

            if(($page == true) && ($page > 0) && ($limit > 0) && is_numeric($page) && is_numeric($limit)){
                $offset = ($page - 1) * $limit;
                $paginated = $this->model->pagination($limit,$offset);
                $this->view->response($paginated);
            }
            else{
                $this->view->response("La pagina $page o el limite $limit no existe, o no es un numero", 404);
            }

        }
        //filtrado
        else if (isset($_GET['filtername'])){
            $filtername = mb_strtolower($_GET['filtername']);
            $name = $this->model->getClientFiltrado($filtername); 
            if(!$name){
                $this->view->response("No existe el campo que contenga $filtername",404);
            }else{
                $filtrado= $this->model->getClientFiltrado($filtername);
                $this->view->response($filtrado);
            }
        }
        else {
            $client = $this->model->getAllClient();
            $this->view->response($client);
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