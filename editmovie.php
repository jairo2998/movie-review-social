<?php 
    require_once("templates/header.php"); 
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    //verify if user is logged in
    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    $movieDao = new MovieDAO($conn, $BASE_URL);
    $id = filter_input(INPUT_GET, "id");

    if (empty($id)) {
        $message->setMessage("O filme não foi encontrado","error","index.php");
    } else {
        $movie = $movieDao->findById($id);

        //check if the movie id exist
        if(!$movie){
            $message->setMessage("O filme não foi encontrado","error","index.php");
        }
    }
    if($movie->image == ""){
        $movie->image = "movie_cover.jpg";
    }
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div class="form-group">
                        <label for="title">Título do Filme:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $movie->title ?>" placeholder="Insira o título do filme" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem do Filme:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label for="length">Duração do Filme:</label>
                        <input type="text" class="form-control" id="length" name="length" value="<?= $movie->length ?>" placeholder="Insira a duração do filme" required> 
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria do Filme:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Ação" <?= $movie->category === "Ação" ? "Selected" : "" ?>>Ação</option>
                            <option value="Comédia" <?= $movie->category === "Comédia" ? "Selected" : "" ?>>Comédia</option>
                            <option value="Drama" <?= $movie->category === "Drama" ? "Selected" : "" ?>>Drama</option>
                            <option value="Fantasia" <?= $movie->category === "Fantasia" ? "Selected" : "" ?>>Fantasia</option>
                            <option value="Ficção Científica" <?= $movie->category === "Ficção Científica" ? "Selected" : "" ?>>Ficção Científica</option>
                            <option value="Romance" <?= $movie->category === "Romance" ? "Selected" : "" ?>>Romance</option>
                            <option value="Terror" <?= $movie->category === "Terror" ? "Selected" : "" ?>>Terror</option>
                            <option value="Suspense" <?= $movie->category === "Suspense" ? "Selected" : "" ?>>Suspense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Trailer do Filme:</label>
                        <input type="text" class="form-control" id="trailer" name="trailer" value="<?= $movie->trailer ?>" placeholder="Insira o link do trailer">
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição do Filme:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Insira a descrição do filme"><?= $movie->description ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Adicionar Filme">
                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"></div>
            </div>
        </div>
    </div>
</div>



<?php require_once("templates/footer.php"); ?>