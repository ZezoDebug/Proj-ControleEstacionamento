<?php

declare(strict_types=1);

namespace src\Domain\ValueObject;

class VehicleType
{
    public function __construct(private string $type)
    {
    }

    public function type(): string
    {
        return $this->type;
    }
}
