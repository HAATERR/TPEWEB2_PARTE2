<?php
require_once './app/models/Team.model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth.api.helper.php';


    class TeamApiController {
        private $model;
        private $view;
        private $data;
        private $authHelper;

        public function __construct() {
            $this->model = new TeamModel();
            $this->view = new ApiView();
            $this->authHelper = new ApiHelper();
            $this->data = file_get_contents("php://input");
        }

        private function getData() {
            return json_decode($this->data);
        }

        public function getTeams($params = null) {
            $teams = $this->model->getAllTeams();
            $this->view->response($teams);
            if (isset($_GET['sort']) && isset($_GET['order'])){
                $sort = $_GET['sort'];
                $order = $_GET['order'];
                if($this->antiInyeccions($sort) && ($order == 'asc' || $order == 'desc' )){
                    $teams = $this->model->getByOrder($sort,$order);
                        if ($teams){
                            $this->view->response($teams,200);
                        }
                        else{
                            $this->view->response("Ese orden no existe",404);
                          }
                    }
                        else{
                            $this->view->response("Ese orden no existe",404);
                        }
                       
                
              }
              else if(isset($_GET['page']) && isset($_GET['limit'])){
                $page = $_GET['page'];
                $limit = $_GET['limit'];
                $page = (int)$page;
                $limit = (int)$limit;
                $off = ($limit * $page) - $limit;
                $teams = $this->model->getPagination($off,$limit);
                if ($teams){
                    $this->view->response($teams);
                }else{
                    $this->view->response("No se encontraron Los Equipos",404);
                }
            }
        }
        public function getTeam($params = null) {
            // obtengo el id del arreglo de params
            $id = $params[':ID'];
            $team = $this->model->teamId($id);

            // si no existe devuelvo 404
            if ($team)
                $this->view->response($team);
            else 
                $this->view->response("El equipo no existe", 404);
        }

        public function deleteTeam($params = null) {
            $id = $params[':ID'];
            $team = $this->model->teamId($id);
            if ($team){   
                  $this->model->delete($id);
                  $this->view->response("El equipo no se pudo eliminar porque tiene jugadores aun, elimine los jugadores pertenecientes a este equipo primero",400);
                }else 
                  $this->view->response("El equipo se elimino correctamente",200);
                
            }
          

        public function insertTeam($params = null) {
            $team = $this->getData();
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            if (empty($team->Team) || empty($team->Rings) || empty($team->City)) {
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insert($team->Team, $team->Rings, $team->City);
                $team = $this->model->teamId($id);
                $this->view->response("Se creo exitosamente", 201);
            }
        }
        public function updateTeam($params = null){
            $id = $params[':ID'];
            $team = $this->model->teamId($id);
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            if ($team){
            $team = $this->getData();
            $id = $this->model->update($team->Team,$team->Rings,$team->City,$id);
            $this->view->response("El equipo se actualizo correctamente",200);
            }else {
            $this->view->response("El equipo no existe",404);
        }
    }
        private function antiInyeccions($columna){
            $whitelist = array(
                0 => 'Team_id',
                1 => 'Team',
                2 => 'Rings',
                3 => 'City'
            );
            return in_array($columna,$whitelist);
    }

    }

