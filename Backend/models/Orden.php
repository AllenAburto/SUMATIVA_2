<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Carrito.php';
require_once __DIR__ . '/Producto.php';

class Orden extends Model {
    protected $tabla = 'ordenes';

    public function createFromCart($usuarioId, $sessionId, $direccion) {
        $db = $this->getConexion();
        $carrito = new Carrito();
        $items = $carrito->getItems($sessionId);

        if (empty($items)) {
            throw new Exception('El carrito esta vacio.');
        }

        $total = $carrito->getTotal($sessionId);

        $db->begin_transaction();

        try {
            $sql = "INSERT INTO {$this->tabla} (usuario_id, total, direccion_envio) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('ids', $usuarioId, $total, $direccion);
            $stmt->execute();
            $ordenId = $db->insert_id;

            $producto = new Producto();
            foreach ($items as $item) {
                $prod = $producto->getById($item['producto_id']);
                if (!$prod || (int)$prod['stock'] < (int)$item['cantidad']) {
                    $stockActual = $prod ? $prod['stock'] : 0;
                    throw new Exception(
                        "Stock insuficiente para \"{$item['nombre']}\": " .
                        "solicitado {$item['cantidad']} uds, disponible {$stockActual} uds. " .
                        "Por favor ajusta la cantidad en el carrito."
                    );
                }
            }

            foreach ($items as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $sql = "INSERT INTO detalles_orden (orden_id, producto_id, cantidad, precio_unitario, subtotal)
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->bind_param('iiidd', $ordenId, $item['producto_id'], $item['cantidad'], $item['precio'], $subtotal);
                $stmt->execute();
                $producto->reducirStock($item['producto_id'], $item['cantidad']);
            }

            $carrito->clear($sessionId);

            $db->commit();
            return $ordenId;

        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    public function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = ? ORDER BY fecha_orden DESC";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('i', $usuarioId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetalle($ordenId) {
        $orden = $this->getById($ordenId);
        if (!$orden) return null;

        $sql = "SELECT d.*, p.nombre, p.imagen, p.marca
                FROM detalles_orden d
                INNER JOIN productos p ON d.producto_id = p.id
                WHERE d.orden_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('i', $ordenId);
        $stmt->execute();
        $orden['items'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $orden;
    }

    public function getAllWithUser() {
        $sql = "SELECT o.*, u.nombre AS nombre_usuario, u.email
                FROM {$this->tabla} o
                INNER JOIN usuarios u ON o.usuario_id = u.id
                ORDER BY o.fecha_orden DESC";
        $resultado = $this->getConexion()->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function updateEstado($ordenId, $estado) {
        return $this->update($ordenId, ['estado' => $estado]);
    }
}