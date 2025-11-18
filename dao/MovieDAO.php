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
            $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id DESC");
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
            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC");
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

        }
        public function getMovieById($id){

        }
        public function findById($id){

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

        }
        public function destroy($id){

        }
    }