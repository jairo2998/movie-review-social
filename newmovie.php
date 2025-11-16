<?php 
    require_once("templates/header.php"); 
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    //verify if user is logged in
    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);

?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Filme</h1>
            <p class="page-description">Aqui você pode adicionar um novo filme ao seu catálogo. </p>
            <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method = "POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">

                <div class="form-group">
                    <label for="title">Título do Filme:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Insira o título do filme" required>
                </div>
                <div class="form-group">
                    <label for="image">Imagem do Filme:</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="length">Duração do Filme:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Insira a duração do filme" required> 
                </div>
                <div class="form-group">
                    <label for="category">Categoria do Filme:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Drama">Drama</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Ficção Científica">Ficção Científica</option>
                        <option value="Romance">Romance</option>
                        <option value="Terror">Terror</option>
                        <option value="Suspense">Suspense</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer do Filme:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
                </div>
                <div class="form-group">
                    <label for="description">Descrição do Filme:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Insira a descrição do filme"></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar Filme">
            </form>
        </div>
    </div>
<?php require_once("templates/footer.php"); ?>