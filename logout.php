<?php
    require_once("globals.php");
    require_once(ROOT_PATH . "templates/header.php");

    if($userDAO){        
        $userDAO->destroyToken();
    }else{
        
    }