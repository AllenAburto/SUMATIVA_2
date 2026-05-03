<?php

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../models/Carrito.php';

try {
    $carritoModel = new Carrito();
    $carritoModel->clear(session_id());

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}