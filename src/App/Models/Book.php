<?php

namespace Paw\App\Models;

use DateTime;
use Paw\Core\AbstractModel;
use Paw\Core\Exceptions\InvalidValueFormatException;

class Book extends AbstractModel {

    public $table = "libros";
    public $fields = [
        "id"               => null,
        "titulo"           => null,
        "autor"            => null,
        "editorial"        => null,
        "precio"           => null,
        "stock"            => null,
        "imagen"           => null,
        "descripcion"      => null,
        "categoria"        => null,
        "idioma"           => null,
        "formato"          => null,
        "cantidad_ventas"  => null,
        "descuento"        => null,
        "created_at"       => null,
        "updated_at"       => null
    ];

    public function setId(int $id) {
        $this->fields["id"] = $id;
    }

    public function setTitulo(string $titulo) {
        if (strlen($titulo) > 60) {
            throw new InvalidValueFormatException("El nombre del libro no puede tener más de 60 caracteres");
        }
        $this->fields["titulo"] = $titulo;
    }

    public function setAutor(string $autor) {
        if (strlen($autor) > 60) {
            throw new InvalidValueFormatException("El nombre del autor no puede tener más de 60 caracteres");
        }
        $this->fields["autor"] = $autor;
    }

    public function setEditorial(string $editorial) {
        if (strlen($editorial) > 60) {
            throw new InvalidValueFormatException("El nombre de la editorial no puede tener más de 60 caracteres");
        }
        $this->fields["editorial"] = $editorial;
    }

    public function setPrecio(float $precio) {
        if ($precio < 0) {
            throw new InvalidValueFormatException("El precio no puede ser negativo");
        }
        $this->fields["precio"] = $precio;
    }

    public function setStock(int $stock) {
        if ($stock < 0) {
            throw new InvalidValueFormatException("El stock no puede ser negativo");
        }
        $this->fields["stock"] = $stock;
    }

    public function setImagen(string $imagen) {
        if (strlen($imagen) > 255) {
            throw new InvalidValueFormatException("La imagen no puede tener más de 255 caracteres");
        }
        $this->fields["imagen"] = $imagen;
    }

    public function setDescripcion(string $descripcion) {
        if (strlen($descripcion) > 255) {
            throw new InvalidValueFormatException("La descripción no puede tener más de 255 caracteres");
        }
        $this->fields["descripcion"] = $descripcion;
    }

    public function setCategoria(string $categoria) {
        $this->fields["categoria"] = $categoria;
    }

    public function setIdioma(string $idioma) {
        $this->fields["idioma"] = $idioma;
    }

    public function setFormato(string $formato) {
        $this->fields["formato"] = $formato;
    }

    public function setCantidadVentas(int $cantidad) {
        if ($cantidad < 0) {
            throw new InvalidValueFormatException("La cantidad de ventas no puede ser negativa");
        }
        $this->fields["cantidad_ventas"] = $cantidad;
    }

    public function setDescuento(float $descuento) {
        if ($descuento < 0 || $descuento > 100) {
            throw new InvalidValueFormatException("El descuento debe estar entre 0 y 100");
        }
        $this->fields["descuento"] = $descuento;
    }

    public function setCreatedAt($created_at) {
        if (is_string($created_at)) {
            try {
                $created_at = new DateTime($created_at);
            } catch (\Exception $e) {
                throw new InvalidValueFormatException("Fecha de creación inválida: " . $e->getMessage());
            }
        }
        if (!$created_at instanceof DateTime) {
            throw new InvalidValueFormatException("objeto DateTime inválido para la fecha de creación");
        }
        $this->fields["created_at"] = $created_at->format('Y-m-d H:i:s');
    }

    public function setUpdatedAt($updated_at) {
        if (is_string($updated_at)) {
            try {
                $updated_at = new DateTime($updated_at);
            } catch (\Exception $e) {
                throw new InvalidValueFormatException("Fecha de actualización inválida: " . $e->getMessage());
            }
        }
        if (!$updated_at instanceof DateTime) {
            throw new InvalidValueFormatException("objeto DateTime inválido para la fecha de actualización");
        }
        $this->fields["updated_at"] = $updated_at->format('Y-m-d H:i:s');
    }

    public function set(array $values): void {
        foreach (array_keys($this->fields) as $field) {
            if (!array_key_exists($field, $values)) {
                continue;
            }
            $method = 'set' . str_replace('_', '', ucwords($field, '_'));
            if (method_exists($this, $method)) {
                $this->{$method}($values[$field]);
            }
        }
    }

    public function precioConDescuento(): float {
        $precio = $this->fields['precio'];
        $descuento = $this->fields['descuento'];
        return round($precio * (1 - $descuento / 100), 2);
    }

    public function __get($name) {
        return $this->fields[$name] ?? null;
    }
}

?>