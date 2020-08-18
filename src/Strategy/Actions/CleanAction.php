<?php

declare(strict_types=1);

namespace App\Strategy\Actions;

use App\Entities\RobotEntity;
use App\Exception\WrongMapPointException;
use App\Services\MapService;
use App\Types\LogTypes;

class CleanAction extends ActionWithLogger implements Contracts\CleanActionContract
{
    private const BATTERY_CAPACITY_USING_UNIT = 5;

    private MapService $mapService;

    public function __construct(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * @param RobotEntity $robotEntity
     * @return int
     * @throws WrongMapPointException
     */
    public function run(RobotEntity $robotEntity): int
    {
        $this->getLoggerService()->addPosition(
            $robotEntity->getPosX(),
            $robotEntity->getPosY(),
            LogTypes::CLEANED
        );

        return self::BATTERY_CAPACITY_USING_UNIT;
    }
}
