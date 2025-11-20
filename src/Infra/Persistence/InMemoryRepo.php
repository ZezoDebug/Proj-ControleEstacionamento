<?php

namespace src\Infra\Persistence;

use src\Domain\Entity\ParkingEntry;
use src\Domain\Repository\ParkingEntryRepository;

final class InMemoryRepo implements ParkingEntryRepository
{
    private array $entries = [];

    public function save(ParkingEntry $entry): void
    {
        $this->entries[] = $entry;
    }

    public function findAll(): array
    {
        return $this->entries;
    }
}
