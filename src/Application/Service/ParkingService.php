<?php

declare(strict_types=1);

namespace src\Application\Service;

use src\Domain\Entity\ParkingEntry;
use src\Domain\Repository\SqliteParkingEntryRepository;
use src\Domain\Service\IVehiclePricingStrategy;
use DateTimeImmutable;

class ParkingService
{
    public function __construct(
        private SqliteParkingEntryRepository $repository,
        private IVehiclePricingStrategy $princingStrategy
    ) {
    }

    public function registerEntry(string $plate, string $vehicleType, ?DateTimeImmutable $entryTime = null): ParkingEntry
    {
        $entryTime = $entryTime ?? new DateTimeImmutable();
        $parkingEntry = new ParkingEntry(
            new \src\Domain\ValueObject\Plate($plate),
            new \src\Domain\ValueObject\VehicleType($vehicleType),
            $entryTime
        );

        $this->repository->save($parkingEntry);

        return $parkingEntry;
    }

    public function calculatePrice(ParkingEntry $entry, ?DateTimeImmutable $exitTime = null): float
    {
        $exitTime = $exitTime ?? new DateTimeImmutable();

        $second = $exitTime->getTimestamp() - $entry->entryTime()->getTimestamp();
        $hours = (int) ceil($second / 3600);

        return $hours * $this->princingStrategy->pricePerHour();
    }
}
