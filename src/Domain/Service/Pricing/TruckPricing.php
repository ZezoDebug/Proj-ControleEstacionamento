<?php

declare(strict_types=1);

namespace src\Domain\Service\Pricing;

use src\Domain\Service\IVehiclePricingStrategy;

class TruckPricing implements IVehiclePricingStrategy
{
    public function pricePerHour(): float
    {
        return 10.0;
    }
}
