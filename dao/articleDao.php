<?php
class ArticleDao {
    private $connection;

    public function __construct($pconnection) {
        $this->connection = $pconnection;
    }

    // ARTICLES

    // Obtenir tots els articles
    public function obtenirArticles() {
        $query = "SELECT * FROM articles";
        $stmt = $this->connection->prepare($query);

        $result = $stmt->execute();
        $articles = [];

        while ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            $article = new Article(
                $fila['id'],
                $fila['titular'],
                $fila['subtitular'],
                $fila['cuerpo'],
                $fila['autor'],
                $fila['categoria'],
                $fila['fecha'],
                $fila['destacado'],
                $fila['vistas']
            );
            $articles[] = $article;
        }
        return $articles;
    }

    // Obtenir un article per ID
    public function obtenirArticlePerId($id) {
        $stmt = $this->connection->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        if($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            $article = new Article(
                $fila['id'],
                $fila['titular'],
                $fila['subtitular'],
                $fila['cuerpo'],
                $fila['autor'],
                $fila['categoria'],
                $fila['fecha'],
                $fila['destacado'],
                $fila['vistas']
            );
            return $article;
        }
        return null;
    }

    // Crear un nou article
    public function crearArticle($article) {
        $query = "INSERT INTO articles (titular, subtitular, cuerpo, autor, categoria, fecha, destacado, vistas) 
                  VALUES (:titular, :subtitular, :cuerpo, :autor, :categoria, :fecha, :destacado, :vistas)
        ";
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':titular', $article->getTitular());
        $stmt->bindValue(':subtitular', $article->getSubtitular());
        $stmt->bindValue(':cuerpo', $article->getCuerpo());
        $stmt->bindValue(':autor', $article->getAutor());
        $stmt->bindValue(':categoria', $article->getCategoria());
        $stmt->bindValue(':fecha', $article->getFecha());
        $stmt->bindValue(':destacado', $article->getDestacado());
        $stmt->bindValue(':vistas', $article->getVistas());

        return $stmt->execute();
    }

}

?>