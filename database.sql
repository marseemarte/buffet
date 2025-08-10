-- Crear base de datos
CREATE DATABASE IF NOT EXISTS buffet;
USE buffet;

-- Crear tabla categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    comentarios TEXT,
    stock INT DEFAULT 0,
    vegetariano BOOLEAN DEFAULT FALSE,
    tacc BOOLEAN DEFAULT TRUE,
    precio DECIMAL(10,2) NOT NULL,
    id_categoria INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

-- Insertar categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Hamburguesas', 'Hamburguesas caseras con diferentes ingredientes'),
('Milanesas', 'Milanesas de carne y pollo'),
('Pollo', 'Platos a base de pollo'),
('Pescado', 'Platos a base de pescado'),
('Ensaladas', 'Ensaladas frescas y saludables'),
('Bebidas', 'Bebidas y jugos naturales');

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, comentarios, stock, vegetariano, tacc, precio, id_categoria) VALUES
('Hamburguesa Clásica', 'Hamburguesa con carne, lechuga, tomate y cebolla', 50, FALSE, TRUE, 2800, 1),
('Hamburguesa con Queso', 'Hamburguesa con queso cheddar derretido', 45, FALSE, TRUE, 3200, 1),
('Hamburguesa Vegetariana', 'Hamburguesa de lentejas con vegetales', 30, TRUE, FALSE, 2500, 1),
('Milanesa de Ternera', 'Milanesa de ternera con pan rallado', 40, FALSE, TRUE, 3500, 2),
('Milanesa de Pollo', 'Milanesa de pollo con especias', 35, FALSE, TRUE, 3000, 2),
('Pollo a la Plancha', 'Pechuga de pollo a la plancha con hierbas', 25, FALSE, FALSE, 2800, 3),
('Pollo Asado', 'Pollo asado con especias y limón', 20, FALSE, FALSE, 3200, 3),
('Salmón a la Plancha', 'Filete de salmón con limón y hierbas', 15, FALSE, FALSE, 4500, 4),
('Ensalada César', 'Lechuga, crutones, parmesano y aderezo césar', 30, FALSE, TRUE, 1800, 5),
('Ensalada Verde', 'Mix de hojas verdes con aceite de oliva', 25, TRUE, FALSE, 1500, 5),
('Limonada Natural', 'Limonada fresca sin conservantes', 100, TRUE, FALSE, 800, 6),
('Jugo de Naranja', 'Jugo de naranja natural exprimido', 80, TRUE, FALSE, 1000, 6);

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_productos_categoria ON productos(id_categoria);
CREATE INDEX idx_productos_nombre ON productos(nombre);
CREATE INDEX idx_productos_stock ON productos(stock);
