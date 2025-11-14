<?php

declare(strict_types=1);

namespace src\Domain\Service;

use DateTimeImmutable;

class TariffCalculator
{
    public function __construct(
        private IVehiclePricingStrategy $strategy
    ) {
    }

    public function calculate(
        DateTimeImmutable $entry,
        DateTimeImmutable $exit
    ): float {
        $seconds = $exit->getTimestamp() - $entry->getTimestamp();

        if ($seconds <= 0) {
            throw new \InvalidArgumentException('O horário de saída deve ser posterior ao horário de entrada.');
        }

        $hours = (int) ceil($seconds / 3600);

        return $hours * $this->strategy->pricePerHour();
    }
}
