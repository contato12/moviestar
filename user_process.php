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

    if ($type==="update") {

        $userData = $userDao->verifyToken();

        //Recebendo dados formulário enviado.
        $name=filter_input(INPUT_POST, "name");
        $lastname=filter_input(INPUT_POST, "lastname");
        $email=filter_input(INPUT_POST, "email");
        $bio=filter_input(INPUT_POST, "bio");

        $user = new User();

        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;
        
        $userDao->update($userData);

    } else if ($type==="changepassword") {
        # code...
    }else{
        $message->setMessage("Informações inválidas.", "error", "index.php");
    }
    
?>