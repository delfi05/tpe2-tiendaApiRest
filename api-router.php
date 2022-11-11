<?php
require_once './libs/Router.php';
require_once './app/controllers/clienteapi.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('cliente', 'GET', 'ClienteApiController', 'getAllClient');
$router->addRoute('cliente/:ID', 'GET', 'ClienteApiController', 'getClient');
$router->addRoute('cliente', 'POST', 'ClienteApiController', 'insertClient');
$router->addRoute('cliente/:ID', 'PUT', 'ClienteApiController', 'editClient');
$router->addRoute('cliente/:ID', 'DELETE', 'ClienteApiController', 'deleteClient');
 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);