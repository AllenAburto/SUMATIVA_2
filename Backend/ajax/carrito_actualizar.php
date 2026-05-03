<?php

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';

$productoId = (int)($_POST['producto_id'] ?? 0);
$cantidad   = (int)($_POST['cantidad'] ?? 0);

if (!$productoId || $cantidad < 1) {
    echo json_encode(['success' => false, 'mensaje' => 'Datos no válidos.']);
    exit;
}

try {
    $productoModel   = new Producto();
    $producto        = $productoModel->getById($productoId);
    $stockDisponible = (int)($producto['stock'] ?? 0);

    if ($cantidad > $stockDisponible) {
        $cantidad = $stockDisponible;
    }

    $carritoModel = new Carrito();
    $sessionId    = session_id();

    $carritoModel->updateCantidad($sessionId, $productoId, $cantidad);

    $items = $carritoModel->getItems($sessionId);
    $total = $carritoModel->getTotal($sessionId);
    $count = $carritoModel->getCount($sessionId);

    echo json_encode([
        'success'     => true,
        'items'       => $items,
        'total'       => number_format($total, 0, ',', '.'),
        'count'       => (int)$count,
        'cantidadReal' => $cantidad,
        'aviso'       => ($cantidad < (int)$_POST['cantidad']) ? "Cantidad ajustada al stock disponible ({$stockDisponible} uds)." : null
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}