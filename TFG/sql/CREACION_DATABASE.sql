CREATE TABLE Roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255),  
    rol_id INT,  
    FOREIGN KEY (rol_id) REFERENCES Roles(id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    autor_id INT,  -- El usuario que crea la noticia (relación con Usuarios)
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES Usuarios(id)
);


CREATE TABLE Permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);

CREATE TABLE RolesPermisos (
    rol_id INT,
    permiso_id INT,
    FOREIGN KEY (rol_id) REFERENCES Roles(id),
    FOREIGN KEY (permiso_id) REFERENCES Permisos(id),
    PRIMARY KEY (rol_id, permiso_id)
);

CREATE TABLE Comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenido TEXT NOT NULL,
    autor_id INT,  -- Usuario que hizo el comentario
    noticia_id INT,  -- Noticia en la que se realiza el comentario
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES Usuarios(id),
    FOREIGN KEY (noticia_id) REFERENCES Noticias(id)
);



