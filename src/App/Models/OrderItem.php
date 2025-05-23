<?php

namespace Paw\App\Models;

use Paw\Core\AbstractModel;
use Paw\Core\Exceptions\InvalidValueFormatException;

class OrderItem extends AbstractModel {
    public $table = "Order_Items";
    public $fields = [
        "order_id"   => null,
        "book_id"    => null,
        "formato"    => null,
        "cantidad"   => null,
        "precio_unit"=> null,
        "descuento_unit"=>  null
    ];

    public $primaryKey = ['order_id','book_id','formato'];

    public function setOrderId(int $orderId) {
        if ($orderId <= 0) {
            throw new InvalidValueFormatException("El order_id debe ser un entero positivo");
        }
        $this->fields["order_id"] = $orderId;
    }

    public function setBookId(int $bookId) {
        if ($bookId <= 0) {
            throw new InvalidValueFormatException("El book_id debe ser un entero positivo");
        }
        $this->fields["book_id"] = $bookId;
    }

    public function setFormato(string $formato) {
        $formato = trim($formato);
        if ($formato === '') {
            throw new InvalidValueFormatException("El formato no puede estar vacío");
        }
        if (strlen($formato) > 100) {
            throw new InvalidValueFormatException("El formato no puede exceder 100 caracteres");
        }
        $this->fields["formato"] = $formato;
    }

    public function setCantidad(int $cantidad) {
        if ($cantidad < 1) {
            throw new InvalidValueFormatException("La cantidad debe ser al menos 1");
        }
        $this->fields["cantidad"] = $cantidad;
    }

    public function setPrecioUnit(float $precio) {
        if ($precio < 0) {
            throw new InvalidValueFormatException("El precio unitario no puede ser negativo");
        }
        $this->fields["precio_unit"] = round($precio, 2);
    }

    public function setDescuentoUnit(int $descuento) {
        if ($descuento < 0) {
            throw new InvalidValueFormatException("El descuento unitario no puede ser negativo");
        }
        $this->fields["descuento_unit"] = $descuento;
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

    /**
     * Calcula subtotal (cantidad * precio_unit)
     */
    public function subtotal(): float {
        return round(
            $this->fields['cantidad'] * $this->fields['precio_unit'],
            2
        );
    }
}