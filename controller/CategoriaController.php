<?php
include_once __DIR__ . '/../dao/CategoriaDao.php';

class CategoriaController {
    private $categoriaDao;

    public function __construct($connection) {
        $this->categoriaDao = new CategoriaDao($connection);
    }

    public function obtenirCategories() {
        return $this->categoriaDao->obtenirCategories();
    }

    public function obtenirCategoriaPerId($id) {
        return $this->categoriaDao->obtenirCategoriaPerId($id);
    }

    public function crearCategoria($categoria) {
        $this->categoriaDao->crearCategoria($categoria);
    }

    public function actualitzarCategoria($categoria) {
        $this->categoriaDao->actualitzarCategoria($categoria);
    }

    public function eliminarCategoria($id) {
        $this->categoriaDao->eliminarCategoria($id);
    }
}
?>
