<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'mensaje' => 'Acceso denegado.']);
    exit;
}

if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'mensaje' => 'No se recibió ningún archivo.']);
    exit;
}

$file     = $_FILES['imagen'];
$maxSize  = 3 * 1024 * 1024;
$allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
$destDir  = __DIR__ . '/../../Frontend/img/productos/';

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'mensaje' => 'El archivo supera 3MB.']);
    exit;
}

$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowed)) {
    echo json_encode(['success' => false, 'mensaje' => 'Solo se permiten imágenes JPG, PNG, WEBP o GIF.']);
    exit;
}

$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$nombre   = preg_replace('/[^a-z0-9\-]/', '', strtolower(pathinfo($file['name'], PATHINFO_FILENAME)));
$nombre   = substr($nombre, 0, 40);
$filename = $nombre . '-' . time() . '.' . $ext;
$destPath = $destDir . $filename;

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

if (move_uploaded_file($file['tmp_name'], $destPath)) {
    echo json_encode([
        'success'  => true,
        'filename' => $filename,
        'url'      => 'Frontend/img/productos/' . $filename
    ]);
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Error al guardar el archivo.']);
}