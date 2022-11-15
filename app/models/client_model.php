<?php

class ClientModel {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_tienda;charset=utf8', 'root', '');
    }
    
    public function getAllClient($filtername, $sort, $order, $limit, $offset){
        $consultation = "SELECT * FROM cliente";

        if(!empty($filtername)){
            $consultation .= " WHERE nombre LIKE '%$filtername%'";
        }
        if((!empty($sort)) && (!empty($order))){
            $consultation .= " ORDER BY $sort $order";
        }
        if(!empty($limit)){
            $consultation .= " LIMIT $limit OFFSET $offset";
        }

        $query = $this->db->prepare($consultation);
        $query->execute();
        $clients = $query->fetchAll(PDO:: FETCH_OBJ);
        return $clients;
    }

    /*public function validateFieldOrder($sort, $order){
        if(($sort != 'id_cliente') && ($sort != 'nombre') && ($sort != 'apellido') && ($sort != 'dni')){
            return -2;
        }
        if(($order != 'asc') && ($order != 'desc')){
            return -3;
        }
        return 0;
    }*/

    public function getClient($id_cliente){
        $query = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $query->execute([$id_cliente]);
        $clienteById = $query->fetchAll(PDO::FETCH_OBJ);
        return $clienteById;
    }

    public function insertClient($nombre, $apellido, $dni){
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
        $query = $this->db->prepare('DELETE FROM cliente WHERE id_cliente = ?');
        $query->execute([$id]);
    }
    
}