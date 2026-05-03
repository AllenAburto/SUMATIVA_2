-- Creación de la base de datos TechHub Store

-- Este archivo se creo con el fin de facilitar la creación de la BB.DD y sus tablas, además de insertar algunos datos de ejemplo para probar el portal.
-- Con ello, se puede importar directamente en MySQL Workbench o cualquier cliente de MySQL para tener la base de datos lista para usar en el desarrollo del proyecto TechHub Store.  


--Crear BB.DD techhub_store

CREATE DATABASE IF NOT EXISTS techhub_store CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE techhub_store;

--Creación de tablas del e-commerce TechHub Store
-- Tabla: usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
    telefono VARCHAR(20) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla: productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    categoria ENUM('notebooks', 'tablets', 'accesorios', 'monitores', 'perifericos') NOT NULL,
    marca VARCHAR(100) DEFAULT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    destacado TINYINT(1) DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla: carritos
CREATE TABLE IF NOT EXISTS carritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT DEFAULT NULL,
    session_id VARCHAR(100) NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_session_producto (session_id, producto_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla: ordenes
CREATE TABLE IF NOT EXISTS ordenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'completada', 'cancelada') NOT NULL DEFAULT 'pendiente',
    direccion_envio VARCHAR(255) NOT NULL,
    fecha_orden DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- Tabla: detalles_orden
CREATE TABLE IF NOT EXISTS detalles_orden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orden_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB;

--Creación de productos por categoria
-- Notebooks
INSERT INTO productos (nombre, descripcion, precio, stock, categoria, marca, imagen, destacado) VALUES
('MacBook Air M3 15"', 'Notebook ultraligero con chip Apple M3, 8GB RAM, 256GB SSD, pantalla Liquid Retina de 15.3 pulgadas.', 1299990.00, 10, 'notebooks', 'Apple', '', 1),
('Lenovo ThinkPad E14 Gen 5', 'Notebook empresarial con Intel Core i5-1335U, 16GB RAM, 512GB SSD, pantalla 14" Full HD.', 649990.00, 15, 'notebooks', 'Lenovo', '', 0),
('ASUS ROG Strix G16 Gaming', 'Notebook gamer con Intel Core i7-13650HX, RTX 4060, 16GB RAM, 512GB SSD, pantalla 16" 165Hz.', 1499990.00, 8, 'notebooks', 'ASUS', '', 1),
('HP Pavilion 15', 'Notebook versatil con AMD Ryzen 5 7530U, 8GB RAM, 512GB SSD, pantalla 15.6" Full HD.', 549990.00, 20, 'notebooks', 'HP', '', 0);

-- Tablets
INSERT INTO productos (nombre, descripcion, precio, stock, categoria, marca, imagen, destacado) VALUES
('iPad Air M2 11"', 'Tablet con chip Apple M2, 128GB, pantalla Liquid Retina 11", compatible con Apple Pencil Pro.', 699990.00, 12, 'tablets', 'Apple', '', 1),
('Samsung Galaxy Tab S9 FE', 'Tablet con Exynos 1380, 6GB RAM, 128GB, pantalla 10.9" TFT, S Pen incluido, IP68.', 349990.00, 18, 'tablets', 'Samsung', '', 0),
('Lenovo Tab P12', 'Tablet con MediaTek Dimensity 7050, 8GB RAM, 128GB, pantalla 12.7" 2K, Dolby Atmos.', 299990.00, 25, 'tablets', 'Lenovo', '', 0);

-- Accesorios
INSERT INTO productos (nombre, descripcion, precio, stock, categoria, marca, imagen, destacado) VALUES
('Logitech MX Master 3S', 'Mouse inalambrico ergonomico, sensor 8K DPI, scroll MagSpeed, USB-C, Bluetooth, silencioso.', 79990.00, 30, 'accesorios', 'Logitech', '', 0),
('Teclado Mecanico HyperX Alloy Origins', 'Teclado mecanico con switches HyperX Red, retroiluminacion RGB, cuerpo de aluminio, USB-C.', 89990.00, 22, 'accesorios', 'HyperX', '', 0),
('AirPods Pro 2 USB-C', 'Audifonos TWS con cancelacion activa de ruido, audio espacial, estuche MagSafe USB-C, IP54.', 249990.00, 15, 'accesorios', 'Apple', '', 1);

-- Monitores
INSERT INTO productos (nombre, descripcion, precio, stock, categoria, marca, imagen, destacado) VALUES
('Samsung Odyssey G5 27" 165Hz', 'Monitor curvo gaming 27" WQHD, 165Hz, 1ms, HDR10, FreeSync Premium, panel VA.', 289990.00, 10, 'monitores', 'Samsung', '', 0),
('LG UltraWide 34" 34WP65C', 'Monitor ultrawide curvo 34" UWQHD 3440x1440, HDR10, sRGB 99%, USB-C, FreeSync.', 399990.00, 7, 'monitores', 'LG', '', 0);

-- Perifericos
INSERT INTO productos (nombre, descripcion, precio, stock, categoria, marca, imagen, destacado) VALUES
('Webcam Logitech C920 HD Pro', 'Webcam Full HD 1080p, microfono estereo, correccion automatica de luz, compatible con Zoom/Teams.', 49990.00, 35, 'perifericos', 'Logitech', '', 0),
('Sony WH-1000XM5', 'Audifonos over-ear con cancelacion de ruido premium, 30hrs bateria, LDAC, Speak-to-Chat.', 329990.00, 12, 'perifericos', 'Sony', '', 1),
('Hub USB-C 7 en 1 Ugreen', 'Hub multipuerto: HDMI 4K, 3x USB 3.0, lector SD/TF, PD 100W. Compatible Mac/Windows.', 29990.00, 40, 'perifericos', 'Ugreen', '', 0);

-- Creación Usuarios admin (clave: admin123)
INSERT INTO usuarios (nombre, email, password, rol, telefono, direccion) VALUES
('Administrador TechHub', 'admin@techhub.cl', '$2y$10$GVVWYeqfoD03ufYSvJa1oOI0DldxvhZGQt6G6Kqz0a.lFBcx2AqO2', 'admin', '+56912345678', 'Av. Providencia 1234, Santiago');


-- Ordenes de ejemplo
INSERT INTO ordenes (usuario_id, total, estado, direccion_envio) VALUES
(2, 1949980.00, 'completada', 'Los Leones 567, Providencia'),
(2, 329990.00, 'pendiente', 'Los Leones 567, Providencia');

INSERT INTO detalles_orden (orden_id, producto_id, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 1, 1299990.00, 1299990.00),
(1, 5, 1, 649990.00, 649990.00),
(2, 14, 1, 329990.00, 329990.00);