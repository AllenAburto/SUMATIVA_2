<?php

require_once __DIR__ . '/Model.php';

class Usuario extends Model {
    protected $tabla = 'usuarios';

    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getRol() { return $this->rol; }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El formato del email no es valido.');
        }
        $this->email = $email;
    }

    public function setPassword($password) {
        if (strlen($password) < 6) {
            throw new Exception('La password debe tener al menos 6 caracteres.');
        }
        $this->password = $password;
    }

    public function authenticate($email, $password) {
        $sql = "SELECT * FROM {$this->tabla} WHERE email = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    public function register($data) {
        $this->setEmail($data['email']);
        $this->setPassword($data['password']);

        if ($this->emailExists($data['email'])) {
            throw new Exception('El email ya esta registrado.');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->create($data);
    }

    public function emailExists($email) {
        $sql = "SELECT id FROM {$this->tabla} WHERE email = ?";
        $stmt = $this->getConexion()->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->num_rows > 0;
    }
}