<?php

    ini_set('display_errors', true); 
    error_reporting(E_ALL);

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    $type=filter_input(INPUT_POST, "type");

    //Direciona o formulário de acordo com seu tipo.
    if ($type==="register") {

        //Recebendo dados formulário enviado.
        $name=filter_input(INPUT_POST, "name");
        $lastname=filter_input(INPUT_POST, "lastname");
        $email=filter_input(INPUT_POST, "email");
        $password=filter_input(INPUT_POST, "password");
        $cofirm_password=filter_input(INPUT_POST, "confirm_password");
               
        //Verificando se os dados mínimos foram enviados.
        if ($name && $lastname && $email && $password) {

            //Verificar a senha de confirmação.
            if ($password === $cofirm_password) {
                
                //Verificar se já existe e-mail cadastrado.
                if ($userDao->findByEmail($email) === false) {
                    
                    $user = new User();  
                    
                    //Criação de token e senha.
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);
                
                    $user->name=$name;
                    $user->lastname=$lastname;
                    $user->email=$email;
                    $user->password=$finalPassword;
                    $user->token=$userToken;

                    $auth = true;

                    $userDao->create($user, $auth);

                } else { 
                    //Enviar mensagem de email já cadastrado.
                    $message->setMessage("E-mail já cadastrado.", "error", "back");
                }
            } else {
                //Enviar mensagem de senha, de confirmação, direfente.
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }
            
        } else {
            //Enviar mensagem de falta de dados.
            $message->setMessage("Preencha todos os campos.", "error", "back");
        }

    } else if ($type==="login") {

        $email=filter_input(INPUT_POST, "email");
        $password=filter_input(INPUT_POST, "password");
    
        if ($userDao->authenticateUser($email, $password)) {

            $message->setMessage("Seja bem vindo!", "success", "editprofile.php");

        } else { 
            $message->setMessage("Usuário e/ou senha inválidos.", "error", "back");
        } 
            
    } else {
        $message->setMessage("Informações inválidas.", "error", "index.php");
    }
    
?>