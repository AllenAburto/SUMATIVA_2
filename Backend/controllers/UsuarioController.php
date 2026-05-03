<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function loginForm() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php');
            exit;
        }
        include __DIR__ . '/../../views/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->loginForm();
            return;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $error    = '';

        if (empty($email) || empty($password)) {
            $error = 'Por favor completa todos los campos.';
        } else {
            $usuario = $this->usuarioModel->authenticate($email, $password);
            if ($usuario) {
                $_SESSION['usuario_id']  = $usuario['id'];
                $_SESSION['nombre']      = $usuario['nombre'];
                $_SESSION['email']       = $usuario['email'];
                $_SESSION['rol']         = $usuario['rol'];

                if ($usuario['rol'] === 'admin') {
                    header('Location: index.php?page=admin');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                $error = 'Email o contrasena incorrectos.';
            }
        }

        include __DIR__ . '/../../views/login.php';
    }

    public function registroForm() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php');
            exit;
        }
        include __DIR__ . '/../../views/registro.php';
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->registroForm();
            return;
        }

        $nombre          = trim($_POST['nombre'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirmar       = $_POST['confirmar_password'] ?? '';
        $error           = '';

        if (empty($nombre) || empty($email) || empty($password) || empty($confirmar)) {
            $error = 'Por favor completa todos los campos.';
        } elseif ($password !== $confirmar) {
            $error = 'Las contrasenas no coinciden.';
        } else {
            try {
                $id = $this->usuarioModel->register([
                    'nombre'   => $nombre,
                    'email'    => $email,
                    'password' => $password
                ]);

                $_SESSION['usuario_id'] = $id;
                $_SESSION['nombre']     = $nombre;
                $_SESSION['email']      = $email;
                $_SESSION['rol']        = 'cliente';

                header('Location: index.php');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        include __DIR__ . '/../../views/registro.php';
    }

    public function logout() {
        require_once __DIR__ . '/../models/Carrito.php';
        $carrito = new Carrito();
        $carrito->clear(session_id());

        session_destroy();
        header('Location: index.php');
        exit;
    }
}