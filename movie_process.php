<?php

    require_once("globals.php");
    require_once(ROOT_PATH . "db.php");
    require_once(ROOT_PATH . "models/Movie.php");
    require_once(ROOT_PATH . "models/Message.php");
    require_once(ROOT_PATH . "dao/UserDAO.php");
    require_once(ROOT_PATH . "dao/MovieDAO.php");

    $message = new Message($BASE_URL); 
    $userDao = new UserDAO($conn, $BASE_URL);

    $movie = new Movie();
    $movieDao = new MovieDAO($conn, $BASE_URL);
     // User data
    $userData = $userDao->verifyToken(true);
    

    $type = filter_input(INPUT_POST, "type");

    if($type === "create") {   
        // Movie data
        $title = filter_input(INPUT_POST, "title");
        $length = filter_input(INPUT_POST, "length");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $description = filter_input(INPUT_POST, "description");
        $users_id = $userData->id;

        if(!empty($title) && !empty($length) && !empty($category)) {
            $movie->title = $title;
            $movie->length = $length;
            $movie->category = $category;
            $movie->trailer = $trailer;
            $movie->description = $description;
            $movie->users_id = $users_id;

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
                $imageName = $movie->imageGenerateName();
                imagejpeg($imageFile, ROOT_PATH . "img/movies/" . $imageName, 100); 
                $movie->image = $imageName;

            } else {
                $message->setMessage("Por favor, preencha os campos obrigatórios!", "error", "back"); 
            }            
            // Create movie
            $movieDao->create($movie);

        } else {
            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    } else if($type === "delete") {
        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDao->findById($id);
        if($movie){
            //check if yser owe the movie
            if($movie->users_id === $userData->id){
                $movieDao->destroy($movie->id);
            }
        } else{
            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    } else if($type === "update"){
        $title = filter_input(INPUT_POST, "title");
        $length = filter_input(INPUT_POST, "length");
        $image = filter_input(INPUT_POST, "image");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $description = filter_input(INPUT_POST, "description");
        $id = filter_input(INPUT_POST, "id");

        

        $movieData = $movieDao->findById($id);
        if($movieData){
            //check if yser owe the movie
            if($movieData->users_id === $userData->id){
                //update
                if(!empty($title) && !empty($length) && !empty($category)) {
                    $movieData->title = $title;
                    $movieData->length = $length;
                    $movieData->category = $category;
                    $movieData->image = $image;
                    $movieData->trailer = $trailer;
                    $movieData->description = $description;

                   

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
                                $imageName = $movieData->imageGenerateName();
                                imagejpeg($imageFile, ROOT_PATH . "img/movies/" . $imageName, 100); 
                                $movieData->image = $imageName;

                        } else {
                            $message->setMessage("Tipo inválido de imagem!", "error", "back");
                        }   
                        
                    } else {
                        $message->setMessage("Por favor, preencha os campos obrigatórios!", "error", "back"); 
                    }
                    $movieDao->update($movieData);

            } else {
                 $message->setMessage("Informações inválidas!", "error", "index.php");
            }
        } else{
            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    
    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }
}
