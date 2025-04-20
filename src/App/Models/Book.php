<?php

namespace Paw\App\Models;

use DateTime;
use Paw\Core\AbstractModel;
use Paw\Core\Exceptions\InvalidValueFormatException;

class Book extends AbstractModel {

    public $table = "libros";
    public $fields = [
        "id" => null,
        "titulo" => null,
        "autor" => null,
        "editorial" => null,
        "precio" => null,
        "stock" => null,
        "imagen" => null,
        "descripcion" => null,
        "categoria_id" => null,
        "created_at" => null,
        "updated_at" =>null,
        "idioma_id" => null,
        "formato_id" => null
    ];

    public function setNombre(string $titulo){
        if(strlen($titulo) > 60){
            throw new InvalidValueFormatException("El nombre del libro no puede tener más de 60 caracteres");
        }
        $this->fields["titulo"] = $titulo;
    }

    public function setAutor(string $autor){
        if(strlen($autor) > 60){
            throw new InvalidValueFormatException("El nombre del autor no puede tener más de 60 caracteres");
        }
        $this->fields["autor"] = $autor;
    }

    public function setEditorial(string $editorial){
        if(strlen($editorial) > 60){
            throw new InvalidValueFormatException("El nombre de la editorial no puede tener más de 60 caracteres");
        }
        $this->fields["editorial"] = $editorial;
    }

    public function setPrecio(float $precio){
        if($precio < 0){
            throw new InvalidValueFormatException("El precio no puede ser negativo");
        }
        $this->fields["precio"] = $precio;
    }

    public function setStock(int $stock){
        if($stock < 0){
            throw new InvalidValueFormatException("El stock no puede ser negativo");
        }
        $this->fields["stock"] = $stock;
    }

    public function setImagen(string $imagen){
        if(strlen($imagen) > 255){
            throw new InvalidValueFormatException("La imagen no puede tener más de 255 caracteres");
        }
        $this->fields["imagen"] = $imagen;
    }

    public function setDescripcion(string $descripcion){
        if(strlen($descripcion) > 255){
            throw new InvalidValueFormatException("La descripción no puede tener más de 255 caracteres");
        }
        $this->fields["descripcion"] = $descripcion;
    }

    public function setCategoriaId(int $categoria_id){
        if($categoria_id < 0){
            throw new InvalidValueFormatException("El id de la categoría no puede ser negativo");
        }
        $this->fields["categoria_id"] = $categoria_id;
    }

    
    public function setIdiomaId(int $idioma_id){
        if($idioma_id < 0){
            throw new InvalidValueFormatException("El id del idioma no puede ser negativo");
        }
        $this->fields["idioma_id"] = $idioma_id;
    }
    
    public function setFormatoId(int $formato_id){
        if($formato_id < 0){
            throw new InvalidValueFormatException("El formatoId no puede ser negativo");
        }
        $this->fields["formato_id"] = $formato_id;
    }
    
    public function setCreatedAt(DateTime $created_at){
        if (!$created_at instanceof DateTime) {
            throw new InvalidValueFormatException("objeto Datetime invalido para la fecha de creacion");
        }
        $this->fields["created_at"] = $created_at->format('Y-m-d H:i:s');
    }
    
    public function setUpdatedAt(DateTime $updated_at){
        if (!$updated_at instanceof DateTime) {
            throw new InvalidValueFormatException("objeto Datetime invalido para la fecha de actualizacion");
        }
        $this->fields["updated_at"] = $updated_at->format('Y-m-d H:i:s');
    }

    public function set(array $values): void {
        foreach (array_keys($this->fields) as $field) {
            if (!isset($values[$field])) {
                continue;
            }
            $method = "set" . ucfirst($field);
            if (method_exists($this, $method)) {
                $this->$method($values[$field]);
            }
        }
    }

}

?>

