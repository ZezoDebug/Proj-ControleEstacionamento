<?php

declare(strict_types=1);

namespace Src\Domain\Service\Pricing;

use Src\Domain\Service\IVehiclePricingStrategy;

class MotoPricing implements IVehiclePricingStrategy
{
    public function pricePerHour(): float
    {
        return 3.0;
    }
}
