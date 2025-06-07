USE paw_prints_db;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar LONGTEXT NULL,
    role ENUM('cliente', 'empleado', 'admin') NOT NULL DEFAULT 'cliente',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE
    Books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        autor VARCHAR(255),
        editorial VARCHAR(255),
        precio DECIMAL(10, 2),
        stock INT,
        imagen VARCHAR(512),
        descripcion TEXT,
        created_at DATETIME,
        updated_at DATETIME,
        categoria VARCHAR(100),
        idioma VARCHAR(100),
        formato VARCHAR(100),
        cantidad_ventas INT,
        descuento TINYINT
    );

CREATE TABLE
    Orders (
        order_id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telefono VARCHAR(20) NOT NULL,
        user_id INT DEFAULT NULL,
        entrega ENUM ('domicilio', 'sucursal') NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES Users (id)
    );

CREATE TABLE
    Order_Items (
        order_id INT NOT NULL,
        book_id INT NOT NULL,
        formato VARCHAR(100) NOT NULL,
        cantidad INT NOT NULL,
        precio_unit DECIMAL(10, 2) NOT NULL,
        descuento_unit TINYINT NOT NULL DEFAULT 0,
        PRIMARY KEY (order_id, book_id, formato),
        FOREIGN KEY (order_id) REFERENCES Orders (order_id),
        FOREIGN KEY (book_id) REFERENCES Books (id)
    );