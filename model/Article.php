<?php 
class Article {
    private $id;
    private $titular;
    private $subtitular;
    private $cuerpo;
    private $autor;
    private $categoria;
    private $fecha;
    private $destacado;
    private $vistas;

    function __construct($id, $titular, $subtitular, $cuerpo, $autor, $categoria, $fecha, $destacado, $vistas)
    {
        $this->id = $id;
        $this->titular = $titular;
        $this->subtitular = $subtitular;
        $this->cuerpo = $cuerpo;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->fecha = $fecha;
        $this->destacado = $destacado;
        $this->vistas = $vistas;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitular() {
        return $this->titular;
    }

    public function getSubtitular() {
        return $this->subtitular;
    }

    public function getCuerpo() {
        return $this->cuerpo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getDestacado() {
        return $this->destacado;
    }

    public function getVistas() {
        return $this->vistas;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitular($titular) {
        $this->titular = $titular;
    }

    public function setSubtitular($subtitular) {
        $this->subtitular = $subtitular;
    }

    public function setCuerpo($cuerpo) {
        $this->cuerpo = $cuerpo;
    }

    public function setAutor($autor) {
        $this->autor = $autor;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setDestacado($destacado) {
        $this->destacado = $destacado;
    }

    public function setVistas($vistas) {
        $this->vistas = $vistas;
    }
}
?>