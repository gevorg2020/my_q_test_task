<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\LoggerOutputEntity;
use App\Entities\PositionEntity;
use App\Types\LogTypes;
use InvalidArgumentException;

class LoggerService
{
    private LoggerOutputEntity $loggerOutput;

    public function __construct()
    {
        $this->loggerOutput = new LoggerOutputEntity();
    }


    /**
     * @param int $axisX
     * @param int $axisY
     * @param int $command
     */
    public function addPosition(int $axisX, int $axisY, int $command): void
    {
        $position = new PositionEntity();
        $position->setX($axisX);
        $position->setY($axisY);

        switch ($command) {
            case LogTypes::VISITED:
                if ($this->checkPresentPosition($position, $this->loggerOutput->getVisited())) {
                    $this->loggerOutput->addVisited($position);
                }
                break;
            case LogTypes::CLEANED:
                if ($this->checkPresentPosition($position, $this->loggerOutput->getCleaned())) {
                    $this->loggerOutput->addCleaned($position);
                }
                break;
            default:
                throw new InvalidArgumentException("Output Argument $command does not exist");
        }
    }

    public function getLoggerOutput(): LoggerOutputEntity
    {
        return $this->loggerOutput;
    }

    /**
     * @param PositionEntity   $position
     * @param PositionEntity[] $visitPositions
     *
     * @return bool
     */
    private function checkPresentPosition(PositionEntity $position, array $visitPositions): bool
    {
        foreach ($visitPositions as $visitPosition) {
            if ($position == $visitPosition) {
                return false;
            }
        }

        return true;
    }
}
