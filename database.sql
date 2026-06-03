-- Script de base de datos para Destellos Joyería (PostgreSQL)

-- 1. Crear extensiones útiles (opcional)
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- 2. Definir Enums
CREATE TYPE estado_pedido AS ENUM ('pendiente', 'pagado', 'enviado', 'cancelado');

-- 3. Tabla de Categorías
CREATE TABLE categorias (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    fecha_creacion TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabla de Productos
CREATE TABLE productos (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(12, 2) NOT NULL CHECK (precio >= 0),
    imagen_url VARCHAR(255),
    stock INT DEFAULT 0 CHECK (stock >= 0),
    categoria_id INT,
    fecha_creacion TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_categoria FOREIGN KEY (categoria_id) 
        REFERENCES categorias(id) ON DELETE SET NULL
);

-- 5. Tabla de Usuarios
CREATE TABLE usuarios (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabla de Pedidos
CREATE TABLE pedidos (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(12, 2) NOT NULL DEFAULT 0,
    estado estado_pedido DEFAULT 'pendiente',
    fecha_pedido TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) 
        REFERENCES usuarios(id) ON DELETE CASCADE
);

-- 7. Detalle de Pedidos
CREATE TABLE detalle_pedidos (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    precio_unitario DECIMAL(12, 2) NOT NULL,
    CONSTRAINT fk_pedido FOREIGN KEY (pedido_id) 
        REFERENCES pedidos(id) ON DELETE CASCADE,
    CONSTRAINT fk_producto FOREIGN KEY (producto_id) 
        REFERENCES productos(id) ON DELETE RESTRICT
);

-- 8. Mensajes de Contacto
CREATE TABLE mensajes_contacto (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    asunto VARCHAR(200),
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- 9. Datos iniciales de categorías
INSERT INTO categorias (nombre) VALUES 
('Anillos'), 
('Aretes'), 
('Collares'), 
('Pulseras'), 
('Jueguitos'), 
('Cadenas'), 
('Ofertas');
