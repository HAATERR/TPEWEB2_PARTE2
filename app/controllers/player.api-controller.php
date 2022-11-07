<?php
require_once './app/models/Player.model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth.api.helper.php';

    class PlayerApiController {
        private $model;
        private $view;
        private $data;
        private $helper;

        public function __construct() {
            $this->model = new PlayerModel();
            $this->view = new ApiView();
            $this->helper = new ApiHelper();
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
              $players = $this->model->getByOrder($sort,$order);
              if ($players){
                $this->view->response($players);
              }
              else{
                $this->view->response("Ese orden no existe",404);
              }
        
            }
            else if(isset($_GET['page']) && isset($_GET['limit'])){
                $page = $_GET['page'];
                $limit = $_GET['limit'];
                $players = $this->model->getPagination($page,$limit);
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
            if ($player)
                $this->view->response($player);
            else 
                $this->view->response("El jugador con el id=$id no existe", 404);
        }

        public function deletePlayer($params = null) {
            $id = $params[':ID'];
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            $player = $this->model->getPlayer($id);
            if ($player) {
                $this->model->delete($id);
                $this->view->response($player);
            } else 
                $this->view->response("El jugador con el id=$id no existe", 404);
        }

        public function insertPlayer($params = null) {
            $player = $this->getData();
            if(!$this->authHelper->isLoggedIn()){
                $this->view->response("No estas logeado", 401);
                return;
              }
            if (empty($player->Number) || empty($player->Position) || empty($player->Player_Name)) {
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insert($player->number, $player->position, $player->player_Name, $player->team);
                $player = $this->model->getPlayer($id);
                $this->view->response($player, 201);
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
            $id = $this->model->update($player->number,$player->position,$player->player_name,$player->team,$id);
            $this->view->response("El jugador con id=$id se actualizo correctamente",200);
            }else {
            $this->view->response("El jugador no existe",404);
        }
    }
    }