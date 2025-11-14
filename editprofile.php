<?php 
    require_once("globals.php");
    require_once(ROOT_PATH . "templates/header.php"); 
    require_once(ROOT_PATH . "models/User.php");
    require_once(ROOT_PATH . "dao/UserDAO.php");
    
    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);    
    $userData = $userDAO->verifyToken(true);  
    $fullName = $user->getFullName($userData);
    if($userData->image == "") {
        $userData->image = "user.png";
    }
?>
    <div id="main-container" class="container-fluid edit-profile-page">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data" id="edit-profile-form">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">                        
                        <h1><?= $fullName ?></h1>
                        <p class="page-description">Altere seus dados abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nome" value="<?= $userData->name ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Sobrenome" value="<?= $userData->lastname ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" readonly class="form-control disabled" name="email" id="email" placeholder="E-mail" value="<?= $userData->email ?>">
                        </div>
                        <input type="submit" class="btn card-btn" value="Atualizar Perfil">

                    </div>
                    <div class="col-md-4">
                        <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                        <div class="form-group">
                            <label for="image">Imagem do Perfil:</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <label for="bio">Biografia:</label>
                            <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte mais sobre você..."><?= $userData->bio ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Alterar Senha</h2>
                    <p class="page-description">Digite sua nova senha abaixo:</p>
                    <form action="<?= $BASE_URL ?>user_process.php" method="POST" id="change-password-form">
                        <input type="hidden" name="type" value="changepassword">
                        <div class="form-group">
                            <label for="password">Nova Senha:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Digite sua nova senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmação de Senha:</label>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirme sua nova senha">
                        </div>
                        <input type="submit" class="btn card-btn" value="Alterar Senha">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once(ROOT_PATH . "templates/footer.php"); ?>
