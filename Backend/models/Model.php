<?php

require_once __DIR__ . '/../config/database.php';

abstract class Model {
    private $conexion;
    protected $tabla;

    public function __construct() {
        $this->conexion = Database::getConnection();
    }

    protected function getConexion() {
        return $this->conexion;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->tabla}";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function create($data) {
        $campos = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $tipos = $this->getTipos($data);

        $sql = "INSERT INTO {$this->tabla} ({$campos}) VALUES ({$placeholders})";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param($tipos, ...array_values($data));
        $stmt->execute();

        return $this->conexion->insert_id;
    }

    public function update($id, $data) {
        $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
        $tipos = $this->getTipos($data) . 'i';

        $sql = "UPDATE {$this->tabla} SET {$sets} WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $valores = array_values($data);
        $valores[] = $id;
        $stmt->bind_param($tipos, ...$valores);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    private function getTipos($data) {
        $tipos = '';
        foreach ($data as $valor) {
            if (is_int($valor)) {
                $tipos .= 'i';
            } elseif (is_float($valor)) {
                $tipos .= 'd';
            } else {
                $tipos .= 's';
            }
        }
        return $tipos;
    }
}