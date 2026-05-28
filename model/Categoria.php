<?php
class Categoria {
    private $id;
    private $nom;
    private $descripcio;

    function __construct($id, $nom, $descripcio) {
        $this->id = $id;
        $this->nom = $nom;
        $this->descripcio = $descripcio;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescripcio() {
        return $this->descripcio;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDescripcio($descripcio) {
        $this->descripcio = $descripcio;
    }
}
?>