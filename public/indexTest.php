<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use src\Application\Service\ParkingService;
use src\Domain\Service\Pricing\CarPricing;
use src\Domain\Service\Pricing\MotoPricing;
use src\Domain\Service\Pricing\TruckPricing;
use src\Infra\Persistence\InMemoryRepo;
use src\Domain\ValueObject\VehicleType;
use src\Domain\ValueObject\Plate;

// Criando o repositório em memória
$repo = new InMemoryRepo();

// Criando estratégias de tarifa
$pricingStrategies = [
    'carro' => new CarPricing(),
    'moto' => new MotoPricing(),
    'caminhao' => new TruckPricing(),
];

// Criando o serviço para cada tipo (simples para teste)
$services = [];
foreach ($pricingStrategies as $type => $strategy) {
    $services[$type] = new ParkingService($repo, $strategy);
}

// Registrando algumas entradas
$services['carro']->registerEntry('ABC1234', 'carro');
$services['moto']->registerEntry('XYZ9876', 'moto');
$services['caminhao']->registerEntry('TRK1111', 'caminhao');

// Simulando saída 3 horas depois
$exitTime = (new DateTimeImmutable())->modify('+3 hours');

// Calculando faturamento por tipo
$totals = [
    'carro' => 0.0,
    'moto' => 0.0,
    'caminhao' => 0.0,
];

foreach ($repo->findAll() as $entry) {
    $type = strtolower($entry->vehicleType()->type());
    $totals[$type] += $services[$type]->calculatePrice($entry, $exitTime);
}

// Exibindo relatório
echo "===== Relatório de estacionamento =====<br>";
foreach ($totals as $type => $value) {
    $count = count(array_filter($repo->findAll(), fn($e) => strtolower($e->vehicleType()->type()) === $type));
    echo ucfirst($type) . ": $count veículos | Faturamento: R$ " . number_format($value, 2) . "<br>";
}
