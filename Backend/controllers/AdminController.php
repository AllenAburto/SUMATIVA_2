<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Orden.php';
require_once __DIR__ . '/../models/Usuario.php';

class AdminController {

    private $productoModel;
    private $ordenModel;
    private $usuarioModel;

    public function __construct() {
        $this->checkAdmin();
        $this->productoModel = new Producto();
        $this->ordenModel    = new Orden();
        $this->usuarioModel  = new Usuario();
    }

    private function checkAdmin() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public function dashboard() {
        $db = \Database::getConnection();

        $totalProductos = $db->query("SELECT COUNT(*) AS total FROM productos WHERE activo=1")->fetch_assoc()['total'];
        $totalOrdenes   = $db->query("SELECT COUNT(*) AS total FROM ordenes")->fetch_assoc()['total'];
        $totalUsuarios  = $db->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol='cliente'")->fetch_assoc()['total'];
        $ingresos       = $db->query("SELECT COALESCE(SUM(total),0) AS total FROM ordenes WHERE estado='completada'")->fetch_assoc()['total'];

        include __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function productos() {
        $productos = $this->productoModel->getAll();
        include __DIR__ . '/../../views/admin/productos.php';
    }

    public function productoForm($id = null) {
        $producto   = null;
        $categorias = ['notebooks', 'tablets', 'accesorios', 'monitores', 'perifericos'];

        if ($id) {
            $producto = $this->productoModel->getById($id);
            if (!$producto) {
                header('Location: index.php?page=admin_productos');
                exit;
            }
        }

        include __DIR__ . '/../../views/admin/producto_form.php';
    }

    public function productoSave() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_productos');
            exit;
        }

        $id          = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $categorias  = ['notebooks', 'tablets', 'accesorios', 'monitores', 'perifericos'];
        $error       = '';

        $data = [
            'nombre'      => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio'      => (float)($_POST['precio'] ?? 0),
            'stock'       => (int)($_POST['stock'] ?? 0),
            'categoria'   => $_POST['categoria'] ?? '',
            'marca'       => trim($_POST['marca'] ?? ''),
            'imagen'      => trim($_POST['imagen'] ?? ''),
            'destacado'   => isset($_POST['destacado']) ? 1 : 0,
            'activo'      => isset($_POST['activo']) ? 1 : 0,
        ];

        try {
            if (empty($data['nombre'])) throw new Exception('El nombre es obligatorio.');
            if ($data['precio'] <= 0) throw new Exception('El precio debe ser mayor a 0.');
            if ($data['stock'] < 0) throw new Exception('El stock no puede ser negativo.');
            if (!in_array($data['categoria'], $categorias)) throw new Exception('Categoria no valida.');

            if ($id) {
                $this->productoModel->update($id, $data);
            } else {
                $this->productoModel->create($data);
            }

            header('Location: index.php?page=admin_productos&exito=1');
            exit;

        } catch (Exception $e) {
            $error    = $e->getMessage();
            $producto = array_merge(['id' => $id], $data);
            include __DIR__ . '/../../views/admin/producto_form.php';
        }
    }

    public function ordenes() {
        $ordenes = $this->ordenModel->getAllWithUser();
        include __DIR__ . '/../../views/admin/ordenes.php';
    }

    public function updateOrdenEstado() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_ordenes');
            exit;
        }

        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $estados = ['pendiente', 'completada', 'cancelada'];

        if ($id && in_array($estado, $estados)) {
            $this->ordenModel->updateEstado($id, $estado);
        }

        header('Location: index.php?page=admin_ordenes');
        exit;
    }
}