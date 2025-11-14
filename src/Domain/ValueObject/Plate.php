<?php

declare(strict_types=1);

namespace src\Domain\ValueObject;

class Plate
{
    private string $value;

    public function __construct(string $plate)
    {
        $plate = strtoupper(trim($plate));

        $pattern = '/^[A-Z]{3}-?[0-9A-Z]{4}$/';

        if (!preg_match($pattern, $plate)) {
            throw new \InvalidArgumentException("Placa inválida: {$plate}");
        }

        $this->value = str_replace('-', '', $plate);
    }

    public function value(): string
    {
        return $this->value;
    }
}
