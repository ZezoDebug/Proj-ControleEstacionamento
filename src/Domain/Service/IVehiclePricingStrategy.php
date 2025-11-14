<?php

declare(strict_types=1);

namespace Src\Domain\Service;

interface IVehiclePricingStrategy
{
    public function pricePerHour(): float;
}
