<?php

    session_start();
    $BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"] . "?") . "/";
    define('ROOT_PATH', __DIR__ . '/');