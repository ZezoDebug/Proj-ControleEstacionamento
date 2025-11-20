<?php

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['plate']) || !isset($input['vehicleType'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$plate = trim($input['plate']);
$vehicleType = trim($input['vehicleType']);

if (!in_array($vehicleType, ['carro', 'moto', 'caminhao'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid vehicle type']);
    exit;
}

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../../storage/parking.db');
    $repo = new SqliteParkingEntryRepository($pdo);

    $pricingStrategies = [
        'carro' => new CarPricing(),
        'moto' => new MotoPricing(),
        'caminhao' => new TruckPricing(),
    ];

    $service = new ParkingService($repo, $pricingStrategies[$vehicleType]);

    $entry = $service->registerEntry($plate, $vehicleType);

    echo json_encode([
        'success' => true,
        'message' => 'Vehicle registered successfully',
        'entry' => [
            'plate' => $entry->plate()->value(),
            'vehicleType' => $entry->vehicleType()->type(),
            'entryTime' => $entry->entryTime()->format('Y-m-d H:i:s')
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}