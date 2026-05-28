<?php
include_once __DIR__ . '/../includes/db_connect.php';
include_once __DIR__ . '/../controller/ArticleController.php';

header('Content-Type: application/json');

$controller = new ArticleController($db);


?>