CREATE DATABASE IF NOT EXISTS BdProyectoCruzRoja
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE BdProyectoCruzRoja;

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT uq_categorias_nombre UNIQUE (nombre)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(30) NOT NULL,
    CONSTRAINT uq_usuarios_usuario UNIQUE (usuario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recursos (
    id_recurso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT UNSIGNED NOT NULL DEFAULT 0,
    id_categoria INT UNSIGNED NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'Disponible',
    INDEX idx_recursos_categoria (id_categoria),
    INDEX idx_recursos_estado (estado),
    CONSTRAINT fk_recursos_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias (id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS prestamos (
    id_prestamo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_recurso INT UNSIGNED NOT NULL,
    id_usuario INT UNSIGNED NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'Prestado',
    INDEX idx_prestamos_recurso (id_recurso),
    INDEX idx_prestamos_usuario (id_usuario),
    INDEX idx_prestamos_estado (estado),
    CONSTRAINT fk_prestamos_recurso
        FOREIGN KEY (id_recurso)
        REFERENCES recursos (id_recurso)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_prestamos_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios (id_usuario)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS mantenimientos (
    id_mantenimiento INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_recurso INT UNSIGNED NOT NULL,
    problema VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'En revisión',
    INDEX idx_mantenimientos_recurso (id_recurso),
    INDEX idx_mantenimientos_estado (estado),
    CONSTRAINT fk_mantenimientos_recurso
        FOREIGN KEY (id_recurso)
        REFERENCES recursos (id_recurso)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO categorias (nombre) VALUES
    ('Comunicaciones'),
    ('Equipo de Protección Personal'),
    ('Equipo de Rescate'),
    ('Equipo Médico'),
    ('Insumo Médico')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO usuarios (usuario, contrasena, nombre, rol) VALUES
    (
        'admin',
        '$2y$12$guumFodWz7l5P66INYWJG.GXh68lgMmkhyYdduq2M8iRRjA7tOOfS',
        'Administrador del sistema',
        'Administrador'
    )
ON DUPLICATE KEY UPDATE usuario = VALUES(usuario);
