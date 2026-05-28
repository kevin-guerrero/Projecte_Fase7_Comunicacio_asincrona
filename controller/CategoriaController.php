<?php
include_once __DIR__ . '/../dao/CategoriaDao.php';

class CategoriaController {
    private $categoryDao;

    public function __construct($connection) {
        $this->categoryDao = new CategoriaDao($connection);
    }

    public function obtenirCategories() {
        return $this->categoryDao->obtenirCategories();
    }

    public function obtenirCategoriaPerId($id) {
        return $this->categoryDao->obtenirCategoriaPerId($id);
    }

    public function crearCategoria($categoria) {
        $this->categoryDao->crearCategoria($categoria);
    }

    public function actualitzarCategoria($categoria) {
        $this->categoryDao->actualitzarCategoria($categoria);
    }

    public function eliminarCategoria($id) {
        $this->categoryDao->eliminarCategoria($id);
    }
}
?>
