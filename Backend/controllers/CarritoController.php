<?php

require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {

    private $carritoModel;
    private $productoModel;

    public function __construct() {
        $this->carritoModel  = new Carrito();
        $this->productoModel = new Producto();
    }

    public function index() {
        $sessionId = session_id();
        $items     = $this->carritoModel->getItems($sessionId);
        $total     = $this->carritoModel->getTotal($sessionId);

        include __DIR__ . '/../../views/carrito.php';
    }

    public function checkout() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $sessionId = session_id();
        $items     = $this->carritoModel->getItems($sessionId);
        $total     = $this->carritoModel->getTotal($sessionId);

        if (empty($items)) {
            header('Location: index.php?page=carrito');
            exit;
        }

        include __DIR__ . '/../../views/checkout.php';
    }

    public function procesar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=checkout');
            exit;
        }

        $direccion = trim($_POST['direccion'] ?? '');
        $error     = '';

        if (empty($direccion)) {
            $error = 'Por favor ingresa una direccion de envio.';
            $sessionId = session_id();
            $items     = $this->carritoModel->getItems($sessionId);
            $total     = $this->carritoModel->getTotal($sessionId);
            include __DIR__ . '/../../views/checkout.php';
            return;
        }

        try {
            $ordenModel = new \Orden();
            $ordenId    = $ordenModel->createFromCart(
                $_SESSION['usuario_id'],
                session_id(),
                $direccion
            );

            header('Location: index.php?page=orden_detalle&id=' . $ordenId . '&exito=1');
            exit;
        } catch (Exception $e) {
            $error     = $e->getMessage();
            $sessionId = session_id();
            $items     = $this->carritoModel->getItems($sessionId);
            $total     = $this->carritoModel->getTotal($sessionId);
            include __DIR__ . '/../../views/checkout.php';
        }
    }
}