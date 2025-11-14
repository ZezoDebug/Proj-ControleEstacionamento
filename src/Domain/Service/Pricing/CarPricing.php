<?php

declare(strict_types=1);

namespace src\Domain\Service\Pricing;

use src\Domain\Service\IVehiclePricingStrategy;

class CarPricing implements IVehiclePricingStrategy
{
    public function pricePerHour(): float
    {
        return 5.0;
    }
}
