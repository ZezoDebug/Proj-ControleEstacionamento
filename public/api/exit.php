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

if (!$input || !isset($input['plate'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$plate = trim($input['plate']);

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../../storage/parking.db');
    $repo = new SqliteParkingEntryRepository($pdo);

    $entry = $repo->findByPlate($plate);
    if (!$entry) {
        http_response_code(404);
        echo json_encode(['error' => 'Vehicle not found']);
        exit;
    }

    $vehicleType = $entry->vehicleType()->type();
    $pricingStrategies = [
        'carro' => new CarPricing(),
        'moto' => new MotoPricing(),
        'caminhao' => new TruckPricing(),
    ];

    $service = new ParkingService($repo, $pricingStrategies[$vehicleType]);

    $price = $service->exitVehicle($plate);

    echo json_encode([
        'success' => true,
        'message' => 'Vehicle exited successfully',
        'price' => $price,
        'vehicleType' => $vehicleType
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}