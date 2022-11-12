<?php

class PlayerModel{

    function getDB() {
        $db = new PDO('mysql:host=localhost;'.'dbname=db_nba;charset=utf8', 'root', '');
        return $db;
    }


     function getPlayer($id){
        $db = $this->getDB();
        $query = $db->prepare('SELECT players.*, team.* FROM players JOIN team ON players.Team_id_fk = team.Team_id WHERE players.Players_id = ?');
        $query->execute([$id]); 
        $players = $query->fetch(PDO::FETCH_OBJ);
        return $players;
    }
    
    
    function getByOrder($sort,$order){
        try{
            $db = $this->getDB();
            $query = $db->prepare("SELECT players.*, team.* FROM players JOIN team ON players.Team_id_fk = team.Team_id ORDER BY $sort $order");
            $query->execute();
            $players = $query->fetchAll(PDO::FETCH_OBJ);
            return $players;
        }catch (\Throwable $th) {
            return false;
          }

    }
    
    
    function getAllPlayers() {
        // 1. abro conexión a la DB
        $db = $this->getDB();
    
        // 2. ejecuto la sentencia (2 subpasos)
        $query = $db->prepare("SELECT players.*, team.* FROM players JOIN team ON players.Team_id_fk = team.Team_id");
        $query->execute();
    
        // 3. obtengo los resultados
        $players = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $players;
    
    
        
    }

    function getPlayersByTeam($id){
       $db = $this->getDB();
        $query = $db->prepare("SELECT * FROM players WHERE Team_id_fk = ?");
        $query->execute([$id]); 
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }

    function playerId($id){
        $db = $this->getDB();
        $query = $db->prepare('SELECT * FROM players WHERE Players_id = ?');
        $query->execute([$id]);
        $player = $query->fetchAll(PDO::FETCH_OBJ);
        return $player;
    }
    public function getPagination($page,$limit){
        $db = $this->getDB();
        $off = ($limit * $page) - $limit;
        $query = $db->prepare("SELECT players.*, team.* FROM players JOIN team ON players.Team_id_fk = team.Team_id ORDER BY Players_id ASC LIMIT $limit OFFSET $off");
        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
      }
    function insert($number,$position,$player_name,$team){
        
        $db = $this->getDB();
        $query = $db->prepare('INSERT INTO players  (Number, Position, Player_Name, Team_id_fk) VALUES (?, ?, ?, ?)');
        $query->execute([$number,$position,$player_name,$team]);
        return $db->lastInsertId();
        
    }

    function delete($id) {
    $db = $this->getDB();
    $query = $db->prepare("DELETE FROM players WHERE Players_id = ?");
    $query->execute([$id]);
    
    }


    function update($number,$position,$player_name,$team,$id) {
    $db = $this->getDB();
    $query = $db->prepare('UPDATE players SET Number = ?,Position = ?,Player_Name = ?,Team_id_fk = ? WHERE Players_id = ?');
    $query->execute([$number,$position,$player_name,$team,$id]);
    
    }


    

      
}