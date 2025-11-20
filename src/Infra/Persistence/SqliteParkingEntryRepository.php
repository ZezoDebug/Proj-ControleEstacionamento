<?php

declare(strict_types=1);

namespace src\Infra\Persistence;

use PDO;
use src\Domain\Entity\ParkingEntry;
use src\Domain\Repository\ParkingEntryRepository;

final class SqliteParkingEntryRepository implements ParkingEntryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS parking_entries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                plate TEXT NOT NULL,
                vehicle_type TEXT NOT NULL,
                entry_time TEXT NOT NULL
            )
        ");
    }

    public function save(ParkingEntry $entry): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO parking_entries (plate, vehicle_type, entry_time)
            VALUES (:plate, :vehicle_type, :entry_time)
        ");

        $stmt->bindValue(':plate', $entry->plate()->value());
        $stmt->bindValue(':vehicle_type', $entry->vehicleType()->type());
        $stmt->bindValue(':entry_time', $entry->entryTime()->format('Y-m-d H:i:s'));

        $stmt->execute();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT plate, vehicle_type, entry_time FROM parking_entries");
        $entries = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $entries[] = new ParkingEntry(
                new \src\Domain\ValueObject\Plate($row['plate']),
                new \src\Domain\ValueObject\VehicleType($row['vehicle_type']),
                new \DateTimeImmutable($row['entry_time'])
            );
        }
        return $entries;
    }

    public function findByPlate(string $plate): ?ParkingEntry
    {
        $stmt = $this->pdo->prepare("SELECT plate, vehicle_type, entry_time FROM parking_entries WHERE plate = :plate");
        $stmt->bindValue(':plate', $plate);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ParkingEntry(
                new \src\Domain\ValueObject\Plate($row['plate']),
                new \src\Domain\ValueObject\VehicleType($row['vehicle_type']),
                new \DateTimeImmutable($row['entry_time'])
            );
        }
        return null;
    }

    public function deleteByPlate(string $plate): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM parking_entries WHERE plate = :plate");
        $stmt->bindValue(':plate', $plate);
        $stmt->execute();
    }
}