<?php
require_once './libs/Router.php';
require_once './app/controllers/clientapi.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('cliente', 'GET', 'ClientApiController', 'getAllClient');
$router->addRoute('cliente/:ID', 'GET', 'ClientApiController', 'getClient');
$router->addRoute('cliente', 'POST', 'ClientApiController', 'insertClient');
$router->addRoute('cliente/:ID', 'PUT', 'ClientApiController', 'editClient');
$router->addRoute('cliente/:ID', 'DELETE', 'ClientApiController', 'deleteClient');
 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);