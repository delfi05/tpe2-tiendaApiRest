<?php

class ClienteModel {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_tienda;charset=utf8', 'root', '');
    }
 
    public function getAllClientes() {
        $query = $this->db->prepare("SELECT * FROM cliente");
        $query->execute(); 
        $cliente = $query->fetchAll(PDO::FETCH_OBJ);
        return $cliente;
    }

    public function getCliente($id_cliente) {
        $query = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $query->execute([$id_cliente]);
        $clienteById = $query->fetchAll(PDO::FETCH_OBJ);
        return $clienteById;
    }

    public function insertCliente($nombre, $apellido, $dni) {
        $query= $this->db->prepare("INSERT INTO cliente (nombre, apellido, dni) VALUES (?, ?, ?)");
        $query->execute([$nombre, $apellido, $dni]);
        return $this-> db->lastInsertId();
    }

    public function editarCliente($id_cliente, $nombre, $apellido, $dni){ 
        $query = $this->db->prepare("UPDATE `cliente` SET `nombre` = ?, `apellido` = ?, `dni` = ? WHERE `id_cliente` = ?");

        try{
            $query->execute([$nombre, $apellido, $dni, $id_cliente]); 
        }
        catch(PDOException $e){
            var_dump($e);
        }
    }

    public function deleteCliente($id){
        $query= $this->db->prepare('DELETE FROM cliente WHERE id_cliente = ?');
        $query->execute([$id]);
    }
}