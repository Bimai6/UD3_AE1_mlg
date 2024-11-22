-- Creación de la base de datos
CREATE DATABASE my_bbdd;

-- Selección de la base de datos
USE my_bbdd;

-- Creación de la tabla de roles
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL
);

-- Creación de la tabla de permisos
CREATE TABLE permissions (
    permission_id INT PRIMARY KEY AUTO_INCREMENT,
    permission_name VARCHAR(50) NOT NULL
);

-- Creación de la tabla de relación entre roles y permisos
CREATE TABLE role_permissions (
    role_id INT,
    permission_id INT,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id)
);

-- Creación de la tabla de usuarios
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    password VARCHAR(64) NOT NULL, -- Longitud ajustada para coincidir con hashes SHA-256
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- Insertar roles de muestra
INSERT INTO roles (role_name) VALUES ('admin'), ('user');

-- Insertar permisos de muestra
INSERT INTO permissions (permission_name) VALUES ('view_profile'), ('edit_profile'), ('delete_profile');

-- Insertar la relación entre roles y permisos
INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), -- El rol "admin" tiene todos los permisos
(2, 1);                 -- El rol "user" solo tiene el permiso "view_profile"

-- Insertar usuarios de muestra
INSERT INTO users (user_name, password, role_id) VALUES
('user1', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1), -- Contraseña "1234" cifrada con SHA-256
('user2', 'f8638b979b2f4f793ddb6dbd197e0ee25a7a6ea32b0ae22f5e3c5d119d839e75', 2); -- Contraseña "5678" cifrada con SHA-256