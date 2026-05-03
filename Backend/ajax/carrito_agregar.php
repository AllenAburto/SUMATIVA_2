<?php

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';

$productoId = (int)($_POST['producto_id'] ?? 0);
$cantidad   = max(1, (int)($_POST['cantidad'] ?? 1));

if (!$productoId) {
    echo json_encode(['success' => false, 'mensaje' => 'Producto no válido.']);
    exit;
}

try {
    $productoModel = new Producto();
    $producto      = $productoModel->getById($productoId);

    if (!$producto || !$producto['activo']) {
        echo json_encode(['success' => false, 'mensaje' => 'Producto no encontrado.']);
        exit;
    }

    $carritoModel   = new Carrito();
    $sessionId      = session_id();
    $items          = $carritoModel->getItems($sessionId);
    $cantidadActual = 0;

    foreach ($items as $item) {
        if ((int)$item['producto_id'] === $productoId) {
            $cantidadActual = (int)$item['cantidad'];
            break;
        }
    }

    $totalSolicitado = $cantidadActual + $cantidad;
    $stockDisponible = (int)$producto['stock'];

    if ($totalSolicitado > $stockDisponible) {
        $puedoAgregar = $stockDisponible - $cantidadActual;
        if ($puedoAgregar <= 0) {
            echo json_encode([
                'success' => false,
                'mensaje' => "Ya tienes el máximo disponible de \"{$producto['nombre']}\" en el carrito ({$stockDisponible} uds)."
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => "Solo puedes agregar {$puedoAgregar} más de \"{$producto['nombre']}\" (stock disponible: {$stockDisponible}, ya en carrito: {$cantidadActual})."
            ]);
        }
        exit;
    }

    $carritoModel->addItem($sessionId, $productoId, $cantidad);
    $count = $carritoModel->getCount($sessionId);

    echo json_encode([
        'success' => true,
        'mensaje' => "\"{$producto['nombre']}\" agregado al carrito.",
        'count'   => (int)$count
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}