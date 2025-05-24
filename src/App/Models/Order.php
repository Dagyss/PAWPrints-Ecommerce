<?php

namespace Paw\App\Models;

use DateTime;
use Paw\Core\AbstractModel;
use Paw\Core\Exceptions\InvalidValueFormatException;

class Order extends AbstractModel
{
    public $table = "orders";
    public $fields = [
        "order_id"  => null,
        "nombre"    => null,
        "email"     => null,
        "telefono"  => null,
        "entrega"   => null,
        "total"     => null,
        "created_at" => null,
    ];

    public function setOrderId(int $id)
    {
        if ($id <= 0) {
            throw new InvalidValueFormatException("El order_id debe ser un entero positivo");
        }
        $this->fields["order_id"] = $id;
    }

    public function setNombre(string $nombre)
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new InvalidValueFormatException("El nombre no puede estar vacío");
        }
        if (strlen($nombre) > 100) {
            throw new InvalidValueFormatException("El nombre no puede exceder 100 caracteres");
        }
        $this->fields["nombre"] = $nombre;
    }

    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidValueFormatException("Email inválido");
        }
        $this->fields["email"] = $email;
    }

    public function setTelefono(?string $telefono)
    {
        if ($telefono === null || $telefono === '') {
            $this->fields["telefono"] = null;
            return;
        }
        if (!preg_match('/^\+?\d{7,15}$/', $telefono)) {
            throw new InvalidValueFormatException("Teléfono inválido");
        }
        $this->fields["telefono"] = $telefono;
    }

    public function setEntrega(string $entrega)
    {
        $opciones = ['domicilio', 'sucursal'];
        if (!in_array($entrega, $opciones, true)) {
            throw new InvalidValueFormatException("Opción de entrega inválida");
        }
        $this->fields["entrega"] = $entrega;
    }

    public function setTotal(float $total)
    {
        if ($total < 0) {
            throw new InvalidValueFormatException("El total no puede ser negativo");
        }
        $this->fields["total"] = round($total, 2);
    }

    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            try {
                $createdAt = new DateTime($createdAt);
            } catch (\Exception $e) {
                throw new InvalidValueFormatException("Fecha de creación inválida: " . $e->getMessage());
            }
        }
        if (!$createdAt instanceof DateTime) {
            throw new InvalidValueFormatException("Objetivo DateTime inválido para created_at");
        }
        $this->fields["created_at"] = $createdAt->format('Y-m-d H:i:s');
    }
    
    public function getCreatedAt(string $created_at): string {
        $rawDate = $created_at;

        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $rawDate);
        if (!$dateTime) {
            return $rawDate;
        }

        return $dateTime->format('d/m/Y H:i') . 'hs';
    }

    public function set(array $values): void
    {
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
    
    public function __get($name) {
        return $this->fields[$name] ?? null;
    }
}
