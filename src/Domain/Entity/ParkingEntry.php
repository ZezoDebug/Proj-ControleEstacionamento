<?php

declare(strict_types=1);

namespace src\Domain\Entity;

use src\Domain\ValueObject\VehicleType;
use src\Domain\ValueObject\Plate;
use DateTimeImmutable;

class ParkingEntry
{
    public function __construct(
        private Plate $plate,
        private VehicleType $vehicleType,
        private DateTimeImmutable $entryTime
    ) {
    }

    public function plate(): Plate
    {
        return $this->plate;
    }

    public function vehicleType(): VehicleType
    {
        return $this->vehicleType;
    }

    public function entryTime(): DateTimeImmutable
    {
        return $this->entryTime;
    }
}
