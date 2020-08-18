<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CleanRobotDto;
use App\Entities\RobotEntity;
use App\Exception\ZeroBatteryException;

class BatteryService
{
    /**
     * @param RobotEntity $robotEntity
     * @param int $unit
     *
     * @throws  ZeroBatteryException
     */
    public function dicreeseBattaryCharge(RobotEntity $robotEntity, int $unit): void
    {
        $unit = $robotEntity->getChargingOfBattery() - $unit;

        if ($unit <= 0) {
            throw new ZeroBatteryException('Battery discharged');
        }

        $robotEntity->setChargingOfBattery($unit);
    }
}
