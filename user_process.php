<?php
    require_once("globals.php");
    require_once(ROOT_PATH . "db.php");
    require_once(ROOT_PATH . "models/User.php");
    require_once(ROOT_PATH . "models/Message.php");
    require_once(ROOT_PATH . "dao/UserDAO.php");

    $message = new Message($BASE_URL); 
    $userDAO = new UserDAO($conn, $BASE_URL);
    $user = new User();
    

    $type = filter_input(INPUT_POST, "type");

    if($type === "update") {
        
        $userData = $userDAO->verifyToken(true);
       // var_dump($userData); exit;
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $bio = filter_input(INPUT_POST, "bio");
                             
        $userData->name = $name;        
        $userData->lastname = $lastname;        
        $userData->bio = $bio;        
        

        // Image upload
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];          
            $fileInfo = pathinfo($image["name"]);            
            $extension = $fileInfo['extension'];
            $allowedExtensions = ["jpg", "jpeg", "png"];
            $jpgExtensions = ["jpg", "jpeg"];

          

           if (in_array($extension, $allowedExtensions)) {
                if(in_array($extension, $jpgExtensions)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }
                if($imageFile === false) {
                    $message->setMessage("Arquivo de imagem inválido!", "error", "back");
                }

            } else {
                $message->setMessage("Tipo inválido de imagem!", "error", "back");
            }   
            $imageName = $user->imageGenerateName();
            imagejpeg($imageFile, ROOT_PATH . "img/users/" . $imageName, 100); 
            $userData->image = $imageName;           

        }

        // Atualizar usuário
        
        $userDAO->update($userData);

        $message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

    } else if($type === "changepassword") {

        $userData = $userDAO->verifyToken(true);

        $password = filter_input(INPUT_POST, "password");

        if(!empty($password)) {

            $password = filter_input(INPUT_POST, "password");
            $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

            if($password !== $confirmPassword) {
                $message->setMessage("As senhas não coincidem!", "error", "editprofile.php");
            }else {
                $finalPassword = $user->generatePassword($password);
                $user->password = $finalPassword;
                $user->id = $userData->id;
                $userDAO->changePassword($user);
                
            }   

            

        } else {
            $message->setMessage("Por favor, insira uma nova senha!", "error", "editprofile.php");
        }

    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }
