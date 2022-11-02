<?php
require_once './libs/Router.php';
require_once './app/controllers/task-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('teams', 'GET', 'TeamApiController', 'getTeams');
$router->addRoute('teams/:ID', 'GET', 'TeamApiController', 'getTeam');
$router->addRoute('teams/:ID', 'DELETE', 'TeamApiController', 'deleteTeam');
$router->addRoute('teams', 'POST', 'TeamApiController', 'insertTeam'); 
$router->addRoute('teams/:ID', 'PUT', 'TeamApiController', 'updateTeam'); 
$router->addRoute('players', 'GET', 'PlayerApiController', 'getPlayers');
$router->addRoute('players/:ID', 'GET', 'PlayerApiController', 'getPlayer');
$router->addRoute('players/:ID', 'DELETE', 'PlayerApiController', 'deletePlayer');
$router->addRoute('players', 'POST', 'PlayerApiController', 'insertPlayer'); 
$router->addRoute('players/:ID', 'PUT', 'PlayerApiController', 'updatePlayer'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);