<?php
require_once './app/models/Player.model.php';
require_once './app/views/api.view.php';

class PlayerApiController {
    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new PlayerModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getPlayers($params = null) {
        $players = $this->model->getAllPlayers();
        $this->view->response($players);
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

        $player = $this->model->getPlayer($id);
        if ($player) {
            $this->model->delete($id);
            $this->view->response($player);
        } else 
            $this->view->response("El equipo con el id=$id no existe", 404);
    }

    public function insertPlayer($params = null) {
        $player = $this->getData();

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

        if ($player){
        $player = $this->getData();
        $id = $this->model->update($player->number,$player->position,$player->player_name,$player->team,$id);
        $this->view->response("El jugador con id=$id se actualizo correctamente",200);
        }else {
        $this->view->response("El jugador no existe",404);
    }
  }
}