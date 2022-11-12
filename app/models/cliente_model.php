<?php

class ClienteModel {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_tienda;charset=utf8', 'root', '');
    }
    
    public function getAllClient($filtername, $sort, $order, $limit, $offset){
        $consultation = "SELECT * FROM cliente";

        if (isset($filtername)){
            $consultation .= " WHERE nombre LIKE '%$filtername%'";
        }
        if ((isset($sort)) && (isset($order))){
            $consultation .= " ORDER BY $sort $order";
        }
        if(isset($limit)){
            $consultation .= " LIMIT $limit OFFSET $offset";
        }

        $query = $this->db->prepare($consultation);
        $query->execute();
        $clients = $query->fetchAll(PDO:: FETCH_OBJ);
        return $clients;
    }


    /* public function getClientOrder($sort, $order) {
        $query = $this->db->prepare("SELECT * FROM `cliente` ORDER BY $sort $order");
        $query->execute(); 
        $clienteordenado = $query->fetchAll(PDO::FETCH_OBJ);
        return $clienteordenado;
    }

    public function getClientFiltrado($filtername) {
        $query = $this->db->prepare("SELECT * FROM `cliente` WHERE `nombre` LIKE '%$filtername%'");
        $query->execute(); 
        $filtrado = $query->fetchAll(PDO::FETCH_OBJ);
        return $filtrado;
    }

    public function pagination($limit,$offset){
        $query = $this->db->prepare("SELECT * FROM `cliente` LIMIT $limit OFFSET $offset");
        $query->execute(); 
        $paginado = $query->fetchAll(PDO::FETCH_OBJ);
        return $paginado;
    }

    public function getAllClient() {
        $query = $this->db->prepare("SELECT * FROM cliente");
        $query->execute(); 
        $cliente = $query->fetchAll(PDO::FETCH_OBJ);
        return $cliente;
    }
*/
    public function getClient($id_cliente) {
        $query = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $query->execute([$id_cliente]);
        $clienteById = $query->fetchAll(PDO::FETCH_OBJ);
        return $clienteById;
    }

    public function insertClient($nombre, $apellido, $dni) {
        $query= $this->db->prepare("INSERT INTO cliente (nombre, apellido, dni) VALUES (?, ?, ?)");
        $query->execute([$nombre, $apellido, $dni]);
        return $this-> db->lastInsertId();
    }

    public function editClient($id, $nombre, $apellido, $dni){ 
        $query = $this->db->prepare("UPDATE `cliente` SET `nombre` = ?, `apellido` = ?, `dni` = ? WHERE `id_cliente` = ?");

        try{
            $query->execute([$nombre, $apellido, $dni, $id]); 
        }
        catch(PDOException $e){
            var_dump($e);
        }
    }

    public function deleteClient($id){
        $query= $this->db->prepare('DELETE FROM cliente WHERE id_cliente = ?');
        $query->execute([$id]);
    }
}