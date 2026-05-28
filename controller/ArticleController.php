<?php 
include_once  __DIR__ .'dao/ArticleDao.php';

class ArticleController {
    private $articleDao;

    public function __construct($connection) {
        $this->articleDao = new ArticleDao($connection);
    }

    public function obtenirArticles() {
        $llistaArticle = $this->articleDao->obtenirArticles();
        return $llistaArticle;
    }

    public function obtenirArticlePerId($id) {
        $article = $this->articleDao->obtenirArticlePerId($id);
        return $article;
    }

    public function crearArticle($article) {
        $this->articleDao->crearArticle($article);
    }

    public function actualitzarArticle($article) {
        $this->articleDao->actualitzarArticle($article);
    }

    public function actualitzarVistaArticle($article) {
        $this->articleDao->actualitzarVistaArticle($article);
    }

    public function eliminarArticle($id) {
        $this->articleDao->deleteArticle($id);
    }
}

?>