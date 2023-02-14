<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    
    $userDao = new UserDAO($conn, $BASE_URL);
    
    $userData = $userDao->verifyToken(true);

    $fullName = $userData->getFullName();

    if ($userData->image == "") {
        $userData->image = "user.png";
    }
?>

   <div id="main-container" class="container-fluid edit-profile-pg">
        <div class="cold-md-12">
            <form action="<?=$BASE_URL?>user_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><?=$fullName?></h1>
                        <p class="page-description">Altere os seus dados no formulário abaixo:</p>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Digite o seu nome." value="<?=$userData->name?>">
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Digite o seu sobrenome." value="<?=$userData->lastname?>">
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control disabled" type="email" readonly name="email" id="email" placeholder="Digite o seu e-mail." value="<?=$userData->email?>">
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <input type="submit" value="Alterar" class="btn card-btn">
                    </div>
                    <div class="col-md-4">
                        <div id="profile-image-container" style="background-image: url('<?=$BASE_URL?>img/users/<?=$userData->image?>')"></div>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="bio">Sobre você:</label>
                            <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte um pouco sobre você ..."><?=$userData->bio?></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Alterar a senha:</h2>
                    <p class="page-description">Digite e confirme a nova senha:</p>
                    <form action="<?=$BASE_URL?>user_process.php" method="post">
                        <input type="hidden" name="type" value="changepassword">
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Digite a nova senha." required>
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <div class="form-group">
                            <label for="confirm_password">Confirmação de Senha:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme a nova senha." required>
                        </div>
                        <!-- _______________________________________________________________________________________________ -->
                        <input type="submit" value="Alterar Senha" class="btn card-btn">
                    </form>
                </div>
            </div>
        </div>
   </div>

<?php
    require_once("templates/footer.php");
?>