DROP DATABASE IF EXISTS city_farmac;
CREATE DATABASE city_farmac CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE city_farmac;

CREATE TABLE categorias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria_padre_id INT UNSIGNED NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_categorias_padre
        FOREIGN KEY (categoria_padre_id) REFERENCES categorias(id)
) ENGINE=InnoDB;

CREATE TABLE marcas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE productos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    modelo VARCHAR(100) NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255) NULL,
    destacado TINYINT(1) NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    categoria_id INT UNSIGNED NOT NULL,
    marca_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_productos_categoria
        FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    CONSTRAINT fk_productos_marca
        FOREIGN KEY (marca_id) REFERENCES marcas(id)
) ENGINE=InnoDB;

CREATE TABLE comentarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto_id INT UNSIGNED NOT NULL,
    email VARCHAR(150) NOT NULL,
    comentario TEXT NOT NULL,
    ranking TINYINT UNSIGNED NOT NULL,
    ip VARCHAR(45) NOT NULL,
    aprobado TINYINT(1) NOT NULL DEFAULT 0,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comentarios_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id),
    CONSTRAINT chk_comentarios_ranking
        CHECK (ranking BETWEEN 1 AND 5)
) ENGINE=InnoDB;