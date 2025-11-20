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

use src\Application\Service\ParkingService;
use src\Domain\Service\Pricing\CarPricing;
use src\Domain\Service\Pricing\MotoPricing;
use src\Domain\Service\Pricing\TruckPricing;
use src\Infra\Persistence\SqliteParkingEntryRepository;

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../../storage/parking.db');
    $repo = new SqliteParkingEntryRepository($pdo);

    $pricingStrategies = [
        'carro' => new CarPricing(),
        'moto' => new MotoPricing(),
        'caminhao' => new TruckPricing(),
    ];

    $services = [];
    foreach ($pricingStrategies as $type => $strategy) {
        $services[$type] = new ParkingService($repo, $strategy);
    }

    $entries = $repo->findAll();
    $totals = [
        'carro' => ['count' => 0, 'revenue' => 0.0],
        'moto' => ['count' => 0, 'revenue' => 0.0],
        'caminhao' => ['count' => 0, 'revenue' => 0.0],
    ];

    foreach ($entries as $entry) {
        $type = strtolower($entry->vehicleType()->type());
        $totals[$type]['count']++;
        $totals[$type]['revenue'] += $services[$type]->calculatePrice($entry);
    }

    echo json_encode(['reports' => $totals]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}