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
    }

    public function save(ParkingEntry $entry): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO parking_entries (plate, vehicle_type, entry_time)
            VALUES (:plate, :vehicle_type, :entry_time)
        ");

        $stmt->bindValue(':plate', $entry->plate()->value());
        $stmt->bindValue(':vehicle_type', $entry->vehicleType()->type());
        // Armazena a data/hora como string no formato ISO 8601 (padrão recomendado para SQLite)
        $stmt->bindValue(':entry_time', $entry->entryTime()->format('Y-m-d H:i:s'));

        $stmt->execute();
    }
}