<?php

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../models/Carrito.php';

$productoId = (int)($_POST['producto_id'] ?? 0);

if (!$productoId) {
    echo json_encode(['success' => false, 'mensaje' => 'Producto no valido.']);
    exit;
}

try {
    $carritoModel = new Carrito();
    $sessionId    = session_id();

    $carritoModel->removeItem($sessionId, $productoId);

    $items = $carritoModel->getItems($sessionId);
    $total = $carritoModel->getTotal($sessionId);
    $count = $carritoModel->getCount($sessionId);

    echo json_encode([
        'success' => true,
        'items'   => $items,
        'total'   => number_format($total, 0, ',', '.'),
        'count'   => (int)$count
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}