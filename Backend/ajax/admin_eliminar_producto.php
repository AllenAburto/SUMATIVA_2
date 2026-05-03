<?php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'mensaje' => 'Acceso denegado.']);
    exit;
}

require_once __DIR__ . '/../models/Producto.php';

$id = (int)($_POST['id'] ?? 0);

if (!$id) {
    echo json_encode(['success' => false, 'mensaje' => 'ID no valido.']);
    exit;
}

try {
    $productoModel = new Producto();
    $productoModel->update($id, ['activo' => 0]);

    echo json_encode(['success' => true, 'mensaje' => 'Producto eliminado correctamente.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
}