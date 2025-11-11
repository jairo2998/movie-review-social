<?php 
    require_once("globals.php");
    require_once(ROOT_PATH . "templates/header.php"); 
    require_once(ROOT_PATH . "dao/UserDAO.php");
    
    $userDAO = new UserDAO($conn, $BASE_URL);    
    $userData = $userDAO->verifyToken(true);
?>
    <div id="main-container" class="container-fluid">
        <h1>Edição de perfil</h1>
    </div>
<?php require_once(ROOT_PATH . "templates/footer.php"); ?>
