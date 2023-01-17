<?php 

    ini_set('display_errors', true); 
    error_reporting(E_ALL);

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    //Criando um objeto para query no banco.
    $userDao = new UserDAO($conn, $BASE_URL);

    //Criando um objeto para tratar o envio de mensagens.
    $message = new Message($BASE_URL);

    //Recebendo dados formulário enviado.
    $name=filter_input(INPUT_POST, "name");
    $lastname=filter_input(INPUT_POST, "lastname");
    $email=filter_input(INPUT_POST, "email");
    $password=filter_input(INPUT_POST, "password");
    $cofirm_password=filter_input(INPUT_POST, "confirm_password");

    //Recebe o tipo de formulário enviado (login ou register).
    $type=filter_input(INPUT_POST, "type");

    //Direciona o formulário de acordo com seu tipo.
    if ($type==="register") {
        
        //Verificando se os dados mínimos foram enviados.
        if ($name && $lastname && $email && $password) {
            //Verificar a senha de confirmação.
            if ($password === $cofirm_password) {
                //Verificar se já existe e-mail cadastrado.
                if ($userDao->findByEmail($email) === false) {
                     echo "E-mail não encontrado!";
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
        # code...
    }
    
?>