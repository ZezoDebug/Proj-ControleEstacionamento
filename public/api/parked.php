<?php

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require __DIR__ . '/../../vendor/autoload.php';

use src\Infra\Persistence\SqliteParkingEntryRepository;

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../../storage/parking.db');
    $repo = new SqliteParkingEntryRepository($pdo);

    $entries = $repo->findAll();
    $parked = array_map(function($entry) {
        return [
            'plate' => $entry->plate()->value(),
            'vehicleType' => $entry->vehicleType()->type(),
            'entryTime' => $entry->entryTime()->format('Y-m-d H:i:s')
        ];
    }, $entries);

    echo json_encode(['parked' => $parked]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}