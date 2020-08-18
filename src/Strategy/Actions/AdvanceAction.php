<?php

declare(strict_types=1);

namespace App\Strategy\Actions;

use App\Entities\RobotEntity;
use App\Types\DirectionTypes;
use App\Exception\WrongMapPointException;
use App\Types\LogTypes;
use App\Services\MapService;
use InvalidArgumentException;

class AdvanceAction extends ActionWithLogger implements Contracts\AdvanceActionContract
{
    private const STEP_LENGTH = 1;

    private const BATTERY_CAPACITY_USING_UNIT = 2;

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
        $axisX = $robotEntity->getPosX();
        $axisY = $robotEntity->getPosY();

        //$this->mapService->isPointOnMap($robotEntity);

        switch ($robotEntity->getDirection()) {
            case DirectionTypes::NORTH:
                $axisY = $axisY - self::STEP_LENGTH;
                break;
            case DirectionTypes::WEST:
                $axisX = $axisX - self::STEP_LENGTH;
                break;
            case DirectionTypes::SOUTH:
                $axisY = $axisY + self::STEP_LENGTH;
                break;
            case DirectionTypes::EAST:
                $axisX = $axisX + self::STEP_LENGTH;
                break;
            default:
                throw new InvalidArgumentException();
        }

        if ($axisX < 0) {
            throw new WrongMapPointException();
        }

        if ($axisY < 0) {
            throw new WrongMapPointException();
        }

        $this->mapService->isPointOnMap($robotEntity);

        $robotEntity->setPosX($axisX);
        $robotEntity->setPosY($axisY);

        $this->getLoggerService()->addPosition($axisX, $axisY, LogTypes::VISITED);

        return self::BATTERY_CAPACITY_USING_UNIT;
    }
}
