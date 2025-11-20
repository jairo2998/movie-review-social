<?php

    require_once("models/Movie.php");
    require_once("models/Message.php");

    class MovieDAO implements MovieDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildMovie($data) {
            $movie = new Movie();

            $movie->id = $data["id"];
            $movie->title = $data["title"];
            $movie->image = $data["image"];
            $movie->length = $data["length"];
            $movie->category = $data["category"];
            $movie->trailer = $data["trailer"];
            $movie->description = $data["description"];
            $movie->users_id = $data["users_id"];

            return $movie;
        }

        public function findall(){

        }
        public function getLatestMovies(){
            $movies = [];
            $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id DESC LIMIT 10");
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }                
            }            
            return $movies;

        }
        public function getMovieByCategory($category){
            $movies = [];
            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC LIMIT 10");
            $stmt->bindParam(":category", $category);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }                
            }            
            return $movies;
        }
        public function getMovieByUserId($id){
            $movies = [];
            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE users_id = :users_id");
            $stmt->bindParam(":users_id", $id);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $moviesArray = $stmt->fetchAll();

                foreach($moviesArray as $movie){
                    $movies[] = $this->buildMovie($movie);
                }                
            }            
            return $movies;

        }
        public function getMovieById($id){

        }
        public function findById($id){
            $movie = [];
            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $movieData = $stmt->fetch();     
                $movie = $this->buildMovie($movieData);    
                return $movie;                     
            } else {
                return false;
            }        
            return $movie;

        }
        public function findByTitle($title){

        }
        public function create(Movie $movie){

            $stmt = $this->conn->prepare("INSERT INTO movies (title, image, length, category, trailer, description, users_id) VALUES (:title, :image, :length, :category, :trailer, :description, :users_id)");
            $stmt->bindParam(":title", $movie->title);  
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":description", $movie->description);
            $stmt->bindParam(":users_id", $movie->users_id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $this->message->setMessage("Filme adicionado com sucesso!", "success", "index.php");
            } else {
                $this->message->setMessage("Erro ao adicionar o filme, tente novamente!", "error", "back");
            }
           
            
        }
        public function update(Movie $movie){

            $stmt =$this->conn->prepare("UPDATE movies SET
                                                title = :title,
                                                description = :description,
                                                image = :image,
                                                category = :category,
                                                trailer = :trailer,
                                                length = :length
                                                WHERE id = :id
            ");
            $stmt->bindParam(":title", $movie->title);
            $stmt->bindParam(":description", $movie->description);
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":id", $movie->id);

            $stmt->execute();

            $this->message->setMessage("Filme atualizado com sucesso!", "success", "dashboard.php");
        }
        public function destroy($id){
            $stmt = $this->conn->prepare("DELETE FROM movies WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $this->message->setMessage("Filme removido com sucesso!", "success", "dashboard.php");
        }
    }