    <?php
        require_once(ROOT_PATH . "dao/UserDAO.php");
        $userData = $userDAO->verifyToken(false);
    ?>
    
    <footer id="footer">
        <div id="social-container">
            <ul>
                <li>
                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </li>
            </ul>
        </div>
        <div id="footer-links-container">
            <ul>
                <li><a href="<?= $BASE_URL ?>newmovie.php">Adicionar filme</a></li>
                <li><a href="#">Adicionar crítica</a></li>
                <?php if(!$userData) : ?>
                    <li><a href="<?= $BASE_URL ?>auth.php">Entrar / Registrar</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <p>&copy; 2025 - MovieStar</p>
    </footer>
    <!-- Bootstrap JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.js" integrity="sha512-GKxQGmCBqm3YHCZTdqD3Bvsz+AHRObqztq6xDo+68527RxgVw7wF1TR5ZSBvtWiz5qzpOzUGGvxJbT/6UzzSOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>


</html>