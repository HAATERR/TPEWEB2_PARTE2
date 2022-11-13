<?php
require_once './app/models/Player.Model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth.api.helper.php';

    class PlayerApiController {
        private $model;
        private $view;
        private $data;
        private $authHelper;

        public function __construct() {
            $this->model = new PlayerModel();
            $this->view = new ApiView();
            $this->authHelper = new ApiHelper();
            $this->data = file_get_contents("php://input");
        }

        private function getData() {
            return json_decode($this->data);
        }

        public function getPlayers($params = null) {
            $players = $this->model->getAllPlayers();
            $this->view->response($players);
            
            if (isset($_GET['sort']) && isset($_GET['order'])){
              $sort = $_GET['sort'];
              $order = $_GET['order'];
              ;
              
              if($this->antiInyeccions($sort) && ($order == 'asc' || $order == 'desc' )){
                $players = $this->model->getByOrder($sort,$order);
                    if ($players){
                        $this->view->response($players,200);
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
                $players = $this->model->getPagination($off,$limit);
                if ($players){
                    $this->view->response($players);
                }else{
                    $this->view->response("No se encontraron Los Jugadores",404);
                }

            }
        }
        public function getPlayer($params = null) {
            // obtengo el id del arreglo de params
            $id = $params[':ID'];
            $player = $this->model->getPlayer($id);
            // si no existe devuelvo 404
            if ($player){
                $this->view->response($player);}
            else {
                $this->view->response("El jugador con el id=$id no existe", 404);
            }
        }

        public function deletePlayer($params = null) {
            $id = $params[':ID'];
            $player = $this->model->getPlayer($id);
            if ($player) {
                $this->model->delete($id);
                $this->view->response("Se elimino correctamente", $player);

            } else 
                $this->view->response("El jugador con el id=$id no existe", 404);
        }

        public function insertPlayer($params = null) {
            $player = $this->getData();
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            if (empty($player->Number) || empty($player->Position) || empty($player->Player_Name) || empty($player->Team_id_fk)){
                $this->view->response("Complete los datos", 400);
            } else {
                
                $id = $this->model->insert($player->Number, $player->Position, $player->Player_Name, $player->Team_id_fk);
                $player = $this->model->getPlayer($id);
                $this->view->response("Se creo exitosamente", 201);
            }
        }
        public function updatePlayer($params = null){
            $id = $params[':ID'];
            $player = $this->model->getPlayer($id);
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            if ($player){
            $player = $this->getData();
            $id = $this->model->update($player->Number,$player->Position,$player->Player_Name,$player->Team_id_fk,$id);
            $this->view->response("El jugador con id=$id se actualizo correctamente",200);
            }else {
            $this->view->response("El jugador no existe",404);
        }
    }
    

        private function antiInyeccions($columna){
            $whitelist = array(
                0 => 'Players_id',
                1 => 'Player_Name',
                2 => 'Position',
                3 => 'Number',
                4 => 'Team_id_fk'
            );
            return in_array($columna,$whitelist);
        }

}