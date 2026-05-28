<?php
class Usuari {
    private $id;
    private $nom;
    private $email;
    private $contrasenya;
    private $rol;
    private $ubicacio;
    private $telefon;
    private $dataRegistre;

    function __construct($id, $nom, $email, $contrasenya, $rol, $ubicacio, $telefon, $dataRegistre) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->contrasenya = $contrasenya;
        $this->rol = $rol;
        $this->ubicacio = $ubicacio;
        $this->telefon = $telefon;
        $this->dataRegistre = $dataRegistre;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getContrasenya() {
        return $this->contrasenya;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getUbicacio() {
        return $this->ubicacio;
    }

    public function getTelefon() {
        return $this->telefon;
    }

    public function getDataRegistre() {
        return $this->dataRegistre;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setContrasenya($contrasenya) {
        $this->contrasenya = $contrasenya;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setUbicacio($ubicacio) {
        $this->ubicacio = $ubicacio;
    }

    public function setTelefon($telefon) {
        $this->telefon = $telefon;
    }

    public function setDataRegistre($dataRegistre) {
        $this->dataRegistre = $dataRegistre;
    }
}
?>