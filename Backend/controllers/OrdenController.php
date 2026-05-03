<?php

require_once __DIR__ . '/../models/Orden.php';

class OrdenController {

    private $ordenModel;

    public function __construct() {
        $this->ordenModel = new Orden();
    }

    public function historial() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $ordenes = $this->ordenModel->getByUsuario($_SESSION['usuario_id']);
        include __DIR__ . '/../../views/historial.php';
    }

    public function detalle($id) {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $orden = $this->ordenModel->getDetalle($id);

        if (!$orden || $orden['usuario_id'] != $_SESSION['usuario_id']) {
            include __DIR__ . '/../../views/errors/404.php';
            return;
        }

        include __DIR__ . '/../../views/orden_detalle.php';
    }
}