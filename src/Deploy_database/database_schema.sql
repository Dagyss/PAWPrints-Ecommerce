USE paw_prints_db;

CREATE TABLE
    Books (
        id INT PRIMARY KEY,
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