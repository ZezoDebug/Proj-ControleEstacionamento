<?php

declare(strict_types=1);

namespace Src\Domain\Service\Pricing;

use Src\Domain\Service\IVehiclePricingStrategy;

class CarPricing implements IVehiclePricingStrategy
{
    public function pricePerHour(): float
    {
        return 5.0;
    }
}
