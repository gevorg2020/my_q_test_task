<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\RobotEntity;
use App\Exception\PointNotOnMapException;
use App\Exception\WrongMapPointException;
use App\Types\MapPointTypes;

class MapService
{
    /**
     * @param RobotEntity $robotEntity
     * @return bool
     * @throws WrongMapPointException
     */
    public function isPointOnMap(RobotEntity $robotEntity): bool
    {
        $map = $robotEntity->getMap();
        if (!isset($map[$robotEntity->getPosY()][$robotEntity->getPosX()])) {
            throw new WrongMapPointException();
        }

        $point = $map[$robotEntity->getPosY()][$robotEntity->getPosX()];

        if ($point !== MapPointTypes::CLEANABLE_SPACE) {
            throw new WrongMapPointException();
        }

        return true;
    }
}
