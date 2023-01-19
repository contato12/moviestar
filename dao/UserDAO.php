<?php 

    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDAO implements UserDAOInterface{

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url)
        {
            $this->conn=$conn;
            $this->url=$url;
            $this->message= new Message($url);
        }

        public function buildUser($data){

            $user = new User();
            
            $user->setId($data["id"]);
            $user->setName($data["name"]);
            $user->setLastname($data["lastname"]);
            $user->setEmail($data["email"]);
            $user->setHashPassword($data["password"]);
            $user->setImage($data["image"]);
            $user->setBio($data["bio"]);
            $user->setToken($data["token"]);

            return $user;

        }

        public function create(User $user, $authUser=false){

            $name = $user->getName();
            $lastname = $user->getLastname();
            $email = $user->getEmail();
            $password = $user->getHashPassword();
            $token = $user->getToken();

            $stmt = $this->conn->prepare("
                INSERT INTO users( 
                    name, lastname, email, password, token
                ) VALUES (
                    :name, :lastname, :email, :password, :token
                )
            ");

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":lastname", $lastname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":token", $token);

            $stmt->execute();

            //Autenticar usuário caso auth seja true.
            if ($authUser) {
                $this->setTokenToSession($token);
            } else {

            }
            
        }

        public function update(User $user){

        }

        public function verifyToken($protected=false){
            if (!empty($_SESSION["token"])) {
                //Pega o token da session
                $token = $_SESSION["token"];
                $user = $this->findByToken($token);
                if ($user) {
                    return $user;
                } else if($protected) {
                    //Redireciona para usuário não autenticado.
                    $this->message->setMessage("Faça o login para acessar a página!", "error", "index.php");
                }
                
            } else if($protected) {
                //Redireciona para usuário não autenticado.
                $this->message->setMessage("Faça o login para acessar a página!", "error", "index.php");
            }
            
        }

        public function setTokenToSession($token, $redirect=true){

            //Salvar token na session.
            $_SESSION["token"] = $token;
            if ($redirect) {
                //Redireciona para o perfil do usuário.
                $this->message->setMessage("Seja Bem-vindo!", "success", "editprofile.php");
            }
        }

        public function authenticateUser($email, $password){

        }

        public function findByEmail($email){
            if ($email != '') {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                if ($stmt->rowCount()>0) {
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);
                    return $user;
                } else {
                    return false;
                }
                
            } else {
                return false;
            }
            
        }   

        public function findById($id){

        }

        public function findByToken($token){
            if ($token != '') {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
                $stmt->bindParam(":token", $token);
                $stmt->execute();
                if ($stmt->rowCount()>0) {
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);
                    return $user;
                } else {
                    return false;
                }
                
            } else {
                return false;
            }

        }

        public function destroyToken(){
            //Remove token da SESSION.
            $_SESSION["token"] = "";

            //Redirecionar com a mensagem de saída com sucesso.
            $this->message->setMessage("Você saiu do sistema!", "success");
        }

        public function changePassword(User $user){

        }

    }


?>