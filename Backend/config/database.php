<?php

class Database {
    private static $conexion = null;

    public static function getConnection() {
        if (self::$conexion === null) {
            self::$conexion = new mysqli('127.0.0.1', 'root', '', 'techhub_store');

            if (self::$conexion->connect_error) {
                die('Error de conexion: ' . self::$conexion->connect_error);
            }

            self::$conexion->set_charset('utf8mb4');
        }

        return self::$conexion;
    }
}