<?php
class CategoriaDao {
    private $connection;

    public function __construct($pconnection) {
        $this->connection = $pconnection;
    }

    // Obtenir totes les categories
    public function obtenirCategories() {
        $query  = "SELECT * FROM categories";
        $stmt   = $this->connection->prepare($query);
        $result = $stmt->execute();
        $categories = [];

        while ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            $categoria = new Categoria(
                $fila['id'],
                $fila['nom'],
                $fila['descripcio']
            );
            $categories[] = $categoria;
        }
        return $categories;
    }

    // Obtenir categoria per ID
    public function obtenirCategoriaPerId($id) {
        $stmt = $this->connection->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        if ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            return new Categoria(
                $fila['id'],
                $fila['nom'],
                $fila['descripcio']
            );
        }
        return null;
    }

    // Crear categoria
    public function crearCategoria($categoria) {
        $query = "INSERT INTO categories (nom, descripcio) VALUES (:nom, :descripcio)";
        $stmt  = $this->connection->prepare($query);

        $stmt->bindValue(':nom',       $categoria->getNom());
        $stmt->bindValue(':descripcio',$categoria->getDescripcio());

        return $stmt->execute();
    }

    // Actualitzar categoria
    public function actualitzarCategoria($categoria) {
        $query = "UPDATE categories SET nom = :nom, descripcio = :descripcio WHERE id = :id";
        $stmt  = $this->connection->prepare($query);

        $stmt->bindValue(':id',        $categoria->getId());
        $stmt->bindValue(':nom',       $categoria->getNom());
        $stmt->bindValue(':descripcio',$categoria->getDescripcio());

        return $stmt->execute();
    }

    // Eliminar categoria
    public function eliminarCategoria($id) {
        $stmt = $this->connection->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

        return $stmt->execute();
    }
}
?>
