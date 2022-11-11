<?php
require_once './libs/Router.php';
require_once './app/controllers/clienteapi.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('cliente', 'GET', 'ClienteApiController', 'getCliente');
$router->addRoute('cliente/:ID', 'GET', 'ClienteApiController', 'getCliente');
$router->addRoute('cliente/:ID', 'DELETE', 'ClienteApiController', 'deleteCliente');
$router->addRoute('cliente', 'POST', 'ClienteApiController', 'insertCliente'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);