<?php
require_once './app/models/Team.model.php';
require_once './app/views/api.view.php';

class TeamApiController {
    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new TeamModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getTeams($params = null) {
        $teams = $this->model->getAllTeams();
        $this->view->response($teams);
    }

    public function getTeam($params = null) {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $team = $this->model->teamId($id);

        // si no existe devuelvo 404
        if ($team)
            $this->view->response($team);
        else 
            $this->view->response("El equipo con el id=$id no existe", 404);
    }

    public function deleteTeam($params = null) {
        $id = $params[':ID'];

        $team = $this->model->teamId($id);
        if ($team) {
            $this->model->delete($id);
            $this->view->response($team);
        } else 
            $this->view->response("El equipo con el id=$id no existe", 404);
    }

    public function insertTeam($params = null) {
        $team = $this->getData();

        if (empty($team->Team) || empty($team->Rings) || empty($team->City)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($team->team, $team->rings, $team->city);
            $team = $this->model->teamId($id);
            $this->view->response($team, 201);
        }
    }
    public function updateTeam($params = null){
        $id = $params[':ID'];
        $team = $this->model->teamId($id);

        if ($team){
        $team = $this->getData();
        $id = $this->model->update($team->Team,$team->Rings,$team->City,$id);
        $this->view->response("El equipo con id=$id se actualizo correctamente",200);
        }else {
        $this->view->response("El equipo no existe",404);
    }
  }


}

