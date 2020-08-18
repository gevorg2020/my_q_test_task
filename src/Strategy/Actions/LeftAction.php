<?php

declare(strict_types=1);

namespace App\Strategy\Actions;

use App\Entities\RobotEntity;
use App\Services\MapService;
use App\Types\DirectionTypes;
use InvalidArgumentException;

class LeftAction implements Contracts\LeftActionContract
{
    private const BATTERY_CAPACITY_USING_UNIT = 1;

    private MapService $mapService;

    /**
     * ActionLeft constructor.
     * @param MapService $mapService
     */
    public function __construct(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * @param RobotEntity $robotEntity
     * @return int
     */
    public function run(RobotEntity $robotEntity): int
    {
        switch ($robotEntity->getDirection()) {
            case DirectionTypes::NORTH:
                $robotEntity->setDirection(DirectionTypes::WEST);
                break;
            case DirectionTypes::WEST:
                $robotEntity->setDirection(DirectionTypes::SOUTH);
                break;
            case DirectionTypes::SOUTH:
                $robotEntity->setDirection(DirectionTypes::EAST);
                break;
            case DirectionTypes::EAST:
                $robotEntity->setDirection(DirectionTypes::NORTH);
                break;
            default:
                throw new InvalidArgumentException();
        }

        return self::BATTERY_CAPACITY_USING_UNIT;
    }
}
