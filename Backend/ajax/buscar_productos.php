<?php

header('Content-Type: application/json');
require_once __DIR__ . '/../models/Producto.php';

$query     = trim($_GET['q'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');
$orden     = trim($_GET['orden'] ?? 'nombre_asc');

try {
    $productoModel = new Producto();
    $productos     = $productoModel->search($query, $categoria, $orden);

    echo json_encode([
        'success'   => true,
        'productos' => $productos,
        'total'     => count($productos)
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}