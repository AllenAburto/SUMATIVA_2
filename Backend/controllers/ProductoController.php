<?php

require_once __DIR__ . '/../models/Producto.php';

class ProductoController {

    private $productoModel;

    public function __construct() {
        $this->productoModel = new Producto();
    }

    public function home() {
        $destacados = $this->productoModel->getDestacados(6);
        include __DIR__ . '/../../views/home.php';
    }

    public function index() {
        $query     = $_GET['q'] ?? '';
        $categoria = $_GET['categoria'] ?? '';
        $orden     = $_GET['orden'] ?? 'nombre_asc';

        $productos  = $this->productoModel->search($query, $categoria, $orden);
        $categorias = ['notebooks', 'tablets', 'accesorios', 'monitores', 'perifericos'];

        include __DIR__ . '/../../views/catalogo.php';
    }

    public function detalle($id) {
        $producto = $this->productoModel->getById($id);

        if (!$producto || !$producto['activo']) {
            include __DIR__ . '/../../views/errors/404.php';
            return;
        }

        include __DIR__ . '/../../views/producto_detalle.php';
    }
}