<?php

require_once __DIR__ . '/Model.php';

class Carrito extends Model {
    protected $tabla = 'carritos';

    public function getItems($sessionId) {
        $sql = "SELECT c.id, c.producto_id, c.cantidad, p.nombre, p.precio, p.imagen, p.stock,
                       (p.precio * c.cantidad) AS subtotal
                FROM {$this->tabla} c
                INNER JOIN productos p ON c.producto_id = p.id
                WHERE c.session_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addItem($sessionId, $productoId, $cantidad = 1) {
        $sql = "INSERT INTO {$this->tabla} (session_id, producto_id, cantidad)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('siii', $sessionId, $productoId, $cantidad, $cantidad);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function updateCantidad($sessionId, $productoId, $cantidad) {
        $sql = "UPDATE {$this->tabla} SET cantidad = ? WHERE session_id = ? AND producto_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('isi', $cantidad, $sessionId, $productoId);
        $stmt->execute();
        return $stmt->affected_rows >= 0;
    }

    public function removeItem($sessionId, $productoId) {
        $sql = "DELETE FROM {$this->tabla} WHERE session_id = ? AND producto_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('si', $sessionId, $productoId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function clear($sessionId) {
        $sql = "DELETE FROM {$this->tabla} WHERE session_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        return true;
    }

    public function getTotal($sessionId) {
        $sql = "SELECT SUM(p.precio * c.cantidad) AS total
                FROM {$this->tabla} c
                INNER JOIN productos p ON c.producto_id = p.id
                WHERE c.session_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] ?? 0;
    }

    public function getCount($sessionId) {
        $sql = "SELECT SUM(cantidad) AS total FROM {$this->tabla} WHERE session_id = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] ?? 0;
    }
}