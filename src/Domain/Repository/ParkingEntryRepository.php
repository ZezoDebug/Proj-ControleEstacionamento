<?php

declare(strict_types=1);

namespace src\Domain\Repository;

use src\Domain\Entity\ParkingEntry;

interface ParkingEntryRepository
{
    public function save(ParkingEntry $entry): void;

    public function findAll(): array;

    public function findByPlate(string $plate): ?ParkingEntry;

    public function deleteByPlate(string $plate): void;
}
