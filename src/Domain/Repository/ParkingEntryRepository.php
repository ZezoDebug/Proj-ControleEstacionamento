<?php

declare(strict_types=1);

namespace src\Domain\Repository;

use src\Domain\Entity\ParkingEntry;

interface ParkingEntryRepositoryInterface
{
    public function save(ParkingEntry $entry): void;
}
