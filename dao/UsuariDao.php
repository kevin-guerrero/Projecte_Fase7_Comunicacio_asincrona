<?php
class UsuariDao {
    private $connection;

    public function __construct($pconnection) {
        $this->connection = $pconnection;
    }

    // Obtenir tots els usuaris
    public function obtenirUsuaris() {
        $query = "SELECT * FROM usuaris";
        $stmt  = $this->connection->prepare($query);
        $result = $stmt->execute();
        $usuaris = [];

        while ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            $usuari = new Usuari(
                $fila['id'],
                $fila['nom'],
                $fila['email'],
                $fila['contrasenya'],
                $fila['rol'],
                $fila['ubicacio'],
                $fila['telefon'],
                $fila['data_registre']
            );
            $usuaris[] = $usuari;
        }
        return $usuaris;
    }

    // Obtenir usuari per ID
    public function obtenirUsuariPerId($id) {
        $stmt = $this->connection->prepare("SELECT * FROM usuaris WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        if ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            return new Usuari(
                $fila['id'],
                $fila['nom'],
                $fila['email'],
                $fila['contrasenya'],
                $fila['rol'],
                $fila['ubicacio'],
                $fila['telefon'],
                $fila['data_registre']
            );
        }
        return null;
    }

    // Obtenir usuari per nom (login)
    public function obtenirUsuariPerNom($nom) {
        $stmt = $this->connection->prepare("SELECT * FROM usuaris WHERE nom = :nom");
        $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($fila = $result->fetchArray(SQLITE3_ASSOC)) {
            return new Usuari(
                $fila['id'],
                $fila['nom'],
                $fila['email'],
                $fila['contrasenya'],
                $fila['rol'],
                $fila['ubicacio'],
                $fila['telefon'],
                $fila['data_registre']
            );
        }
        return null;
    }

    // Crear usuari
    public function crearUsuari($usuari) {
        $query = "INSERT INTO usuaris (nom, email, contrasenya, rol, ubicacio, telefon, data_registre)
                  VALUES (:nom, :email, :contrasenya, :rol, :ubicacio, :telefon, :data_registre)";
        $stmt  = $this->connection->prepare($query);

        $stmt->bindValue(':nom',          $usuari->getNom());
        $stmt->bindValue(':email',        $usuari->getEmail());
        $stmt->bindValue(':contrasenya',  $usuari->getContrasenya());
        $stmt->bindValue(':rol',          $usuari->getRol());
        $stmt->bindValue(':ubicacio',     $usuari->getUbicacio());
        $stmt->bindValue(':telefon',      $usuari->getTelefon());
        $stmt->bindValue(':data_registre',$usuari->getDataRegistre());

        return $stmt->execute();
    }

    // Actualitzar usuari
    public function actualitzarUsuari($usuari) {
        $query = "UPDATE usuaris SET nom = :nom, email = :email, ubicacio = :ubicacio,
                  telefon = :telefon WHERE id = :id";
        $stmt  = $this->connection->prepare($query);

        $stmt->bindValue(':id',       $usuari->getId());
        $stmt->bindValue(':nom',      $usuari->getNom());
        $stmt->bindValue(':email',    $usuari->getEmail());
        $stmt->bindValue(':ubicacio', $usuari->getUbicacio());
        $stmt->bindValue(':telefon',  $usuari->getTelefon());

        return $stmt->execute();
    }

    // Actualitzar contrasenya
    public function actualitzarContrasenya($id, $novaContrasenya) {
        $stmt = $this->connection->prepare("UPDATE usuaris SET contrasenya = :contrasenya WHERE id = :id");
        $stmt->bindValue(':id',          $id, SQLITE3_INTEGER);
        $stmt->bindValue(':contrasenya', $novaContrasenya, SQLITE3_TEXT);

        return $stmt->execute();
    }

    // Eliminar usuari
    public function eliminarUsuari($id) {
        $stmt = $this->connection->prepare("DELETE FROM usuaris WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

        return $stmt->execute();
    }
}
?>
