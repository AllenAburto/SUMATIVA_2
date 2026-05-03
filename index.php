<?php

session_start();

define('BASE_URL', '/Sumativa_2/');
define('IMG_DIR', __DIR__ . '/Frontend/img/productos/');
define('IMG_URL', 'Frontend/img/productos/');

function productoImg(string $imagen, string $alt = '', string $class = ''): string {
    if ($imagen && file_exists(IMG_DIR . basename($imagen))) {
        return '<img src="' . IMG_URL . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($alt) . '" class="' . $class . '">';
    }
    return '<div class="img-placeholder"><i class="fas fa-laptop"></i><span>Sin imagen</span></div>';
}

require_once __DIR__ . '/Backend/controllers/ProductoController.php';
require_once __DIR__ . '/Backend/controllers/UsuarioController.php';
require_once __DIR__ . '/Backend/controllers/CarritoController.php';
require_once __DIR__ . '/Backend/controllers/OrdenController.php';
require_once __DIR__ . '/Backend/controllers/AdminController.php';
require_once __DIR__ . '/Backend/models/Orden.php';

$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? null;
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    switch ($page) {

        case 'home':
            $ctrl = new ProductoController();
            $ctrl->home();
            break;

        case 'catalogo':
            $ctrl = new ProductoController();
            $ctrl->index();
            break;

        case 'producto':
            if (!$id) { header('Location: index.php?page=catalogo'); exit; }
            $ctrl = new ProductoController();
            $ctrl->detalle($id);
            break;

        case 'login':
            $ctrl = new UsuarioController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ctrl->login();
            } else {
                $ctrl->loginForm();
            }
            break;

        case 'registro':
            $ctrl = new UsuarioController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ctrl->registro();
            } else {
                $ctrl->registroForm();
            }
            break;

        case 'logout':
            $ctrl = new UsuarioController();
            $ctrl->logout();
            break;

        case 'carrito':
            $ctrl = new CarritoController();
            $ctrl->index();
            break;

        case 'checkout':
            $ctrl = new CarritoController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ctrl->procesar();
            } else {
                $ctrl->checkout();
            }
            break;

        case 'historial':
            $ctrl = new OrdenController();
            $ctrl->historial();
            break;

        case 'orden_detalle':
            if (!$id) { header('Location: index.php?page=historial'); exit; }
            $ctrl = new OrdenController();
            $ctrl->detalle($id);
            break;

        case 'admin':
            $ctrl = new AdminController();
            $ctrl->dashboard();
            break;

        case 'admin_productos':
            $ctrl = new AdminController();
            $ctrl->productos();
            break;

        case 'admin_producto_form':
            $ctrl = new AdminController();
            $ctrl->productoForm($id);
            break;

        case 'admin_producto_save':
            $ctrl = new AdminController();
            $ctrl->productoSave();
            break;

        case 'admin_ordenes':
            $ctrl = new AdminController();
            $ctrl->ordenes();
            break;

        case 'admin_orden_estado':
            $ctrl = new AdminController();
            $ctrl->updateOrdenEstado();
            break;

        default:
            http_response_code(404);
            include __DIR__ . '/views/errors/404.php';
            break;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo '<div style="font-family:monospace;padding:2rem;color:#c00;">';
    echo '<h2>Error interno del servidor</h2>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div>';
}