<?php
include_once __DIR__ . '/../dao/UsuariDao.php';

class UsuariController {
    private $userDao;

    public function __construct($connection) {
        $this->userDao = new UsuariDao($connection);
    }

    public function obtenirUsuaris() {
        return $this->userDao->obtenirUsuaris();
    }

    public function obtenirUsuariPerId($id) {
        return $this->userDao->obtenirUsuariPerId($id);
    }

    public function obtenirUsuariPerNom($nom) {
        return $this->userDao->obtenirUsuariPerNom($nom);
    }

    public function crearUsuari($usuari) {
        $this->userDao->crearUsuari($usuari);
    }

    public function actualitzarUsuari($usuari) {
        $this->userDao->actualitzarUsuari($usuari);
    }

    public function actualitzarContrasenya($id, $novaContrasenya) {
        $this->userDao->actualitzarContrasenya($id, $novaContrasenya);
    }

    public function eliminarUsuari($id) {
        $this->userDao->eliminarUsuari($id);
    }
}
?>
