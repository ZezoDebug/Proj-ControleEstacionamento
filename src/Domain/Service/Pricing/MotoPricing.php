<?php

declare(strict_types=1);

namespace src\Domain\Service\Pricing;

use src\Domain\Service\IVehiclePricingStrategy;

class MotoPricing implements IVehiclePricingStrategy
{
    public function pricePerHour(): float
    {
        return 3.0;
    }
}
