<?php
require_once './app/models/User.Model.php';
require_once './app/helpers/auth.api.helper.php';
require_once './app/views/api.view.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

    class UserAuthApiController{
        
        public function __construct(){
            
            $this->model = new Usermodel();
        }
        
        public function getToken($params = null) {
            // Obtener "Basic base64(user:pass)
            $basic = $this->authHelper->getAuthHeader();
            if(empty($basic)){
                $this->view->response('No autorizado', 401);
                return;
            }
            $basic = explode(" ",$basic); // ["Basic" "base64(user:pass)"]
            if($basic[0]!="Basic"){
                $this->view->response('La autenticación debe ser Basic', 401);
                return;
            }

            //validar usuario:contraseña
            $userpass = base64_decode($basic[1]); // user:pass
            $userpass = explode(":", $userpass);
            $user = $userpass[0];
            $pass = $userpass[1];
            $authDB = $this->model->getAllUsersByEmail($user);
            if(isset($authDB->email) && password_verify($pass,$authDB->password)){
                //  crear un token
                $header = array(
                    'alg' => 'HS256',
                    'typ' => 'JWT'
                );
                $payload = array(
                    'id' => $authDB->User_id,
                    'name' => "$authDB->email",
                    'exp' => time()+3600
                );
                $header = base64url_encode(json_encode($header));
                $payload = base64url_encode(json_encode($payload));
                $signature = hash_hmac('SHA256', "$header.$payload", "Clave123", true);
                $signature = base64url_encode($signature);
                $token = "$header.$payload.$signature";
                $this->view->response($token);
            }else{
                $this->view->response('No autorizado', 401);
            }
        }

        
    }