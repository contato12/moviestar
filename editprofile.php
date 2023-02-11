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

   <div id="main-container" class="container-fluid">
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
                        <input type="email" name="email" id="email" class="form-control disable" placeholder="Digite o seu e-mail." value="<?=$userData->email?>" readonly>
                    </div>
                    <!-- _______________________________________________________________________________________________ -->
                    <input type="submit" value="Alterar" class="btn form-btn">
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
        </div>
   </div>

<?php
    require_once("templates/footer.php");
?>