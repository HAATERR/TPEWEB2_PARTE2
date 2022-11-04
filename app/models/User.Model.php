<?php

class Usermodel{
    function getDB() {
        $db = new PDO('mysql:host=localhost;'.'dbname=db_nba;charset=utf8', 'root', '');
        return $db;
    }



    function getAllUsersByEmail($email) {
        // 1. abro conexión a la DB
        $db = $this->getDB();
    
        // 2. ejecuto la sentencia (2 subpasos)
        $query = $db->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);
    
        // 3. obtengo los resultados
        return $query->fetch(PDO::FETCH_OBJ);
} 


    
}
