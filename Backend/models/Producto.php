<?php

require_once __DIR__ . '/Model.php';

class Producto extends Model {
    protected $tabla = 'productos';

    private $id;
    private $nombre;
    private $precio;
    private $stock;
    private $categoria;
    private $marca;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }

    public function setPrecio($precio) {
        if ($precio < 0) {
            throw new Exception('El precio no puede ser negativo.');
        }
        $this->precio = $precio;
    }

    public function setStock($stock) {
        if ($stock < 0) {
            throw new Exception('El stock no puede ser negativo.');
        }
        $this->stock = $stock;
    }

    public function search($query = '', $categoria = '', $orden = 'nombre_asc') {
        $sql = "SELECT * FROM {$this->tabla} WHERE activo = 1";
        $params = [];
        $tipos = '';

        if (!empty($query)) {
            $sql .= " AND (nombre LIKE ? OR descripcion LIKE ? OR marca LIKE ?)";
            $busqueda = "%{$query}%";
            $params[] = $busqueda;
            $params[] = $busqueda;
            $params[] = $busqueda;
            $tipos .= 'sss';
        }

        if (!empty($categoria)) {
            $sql .= " AND categoria = ?";
            $params[] = $categoria;
            $tipos .= 's';
        }

        switch ($orden) {
            case 'precio_asc':
                $sql .= " ORDER BY precio ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY precio DESC";
                break;
            case 'nombre_desc':
                $sql .= " ORDER BY nombre DESC";
                break;
            default:
                $sql .= " ORDER BY nombre ASC";
        }

        $stmt = $this->getConexion()->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($tipos, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDestacados($limit = 6) {
        $sql = "SELECT * FROM {$this->tabla} WHERE destacado = 1 AND activo = 1 LIMIT ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getByCategoria($categoria) {
        $sql = "SELECT * FROM {$this->tabla} WHERE categoria = ? AND activo = 1 ORDER BY nombre";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $categoria);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function hayStock($id) {
        $producto = $this->getById($id);
        return $producto && $producto['stock'] > 0;
    }

    public function reducirStock($id, $cantidad) {
        $sql = "UPDATE {$this->tabla} SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('iii', $cantidad, $id, $cantidad);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}