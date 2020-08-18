<?php

declare(strict_types=1);

namespace App\Strategy;

use App\Strategy\Actions\Contracts\AdvanceActionContract;
use App\Strategy\Actions\Contracts\BackActionContract;
use App\Strategy\Actions\Contracts\CleanActionContract;
use App\Strategy\Actions\Contracts\LeftActionContract;
use App\Strategy\Actions\Contracts\RightActionContract;
use App\Types\CommandTypes;
use App\Entities\RobotEntity;
use App\Services\LoggerService;

class RobotStrategy
{
    private RobotEntity $robotEntity;

    private LoggerService $loggerService;

    private LeftActionContract $actionLeft;

    private RightActionContract $actionRight;

    private AdvanceActionContract $actionAdvance;

    private BackActionContract $actionBack;

    private CleanActionContract $actionClean;


    public function __construct(
        LoggerService $loggerService,
        LeftActionContract $actionLeft,
        RightActionContract $actionRight,
        AdvanceActionContract $actionAdvance,
        BackActionContract $actionBack,
        CleanActionContract $actionClean
    ) {
        $this->loggerService = $loggerService;
        $this->actionLeft = $actionLeft;
        $this->actionRight = $actionRight;
        $this->actionAdvance = $actionAdvance;
        $this->actionBack = $actionBack;
        $this->actionClean = $actionClean;
    }

    public function setRobotEntity(RobotEntity $robotEntity): void
    {
        $this->robotEntity = $robotEntity;
    }

    private function actionLeft(LeftActionContract $action): int
    {
        return $action->run($this->robotEntity);
    }

    private function actionRight(RightActionContract $action): int
    {
        return $action->run($this->robotEntity);
    }

    private function actionBack(BackActionContract $action): int
    {
        $action->setLoggerService($this->loggerService);
        return $action->run($this->robotEntity);
    }

    private function actionClean(CleanActionContract $action): int
    {
        $action->setLoggerService($this->loggerService);
        return $action->run($this->robotEntity);
    }

    private function actionAdvance(AdvanceActionContract $action): int
    {
        $action->setLoggerService($this->loggerService);
        return $action->run($this->robotEntity);
    }

    /**
     * @param string $command
     * @return int
     */
    public function execute(string $command): int
    {
        $capacityDischargeUnit = 0;
        switch ($command) {
            case CommandTypes::ADVANCE:
                $capacityDischargeUnit = $this->actionAdvance($this->actionAdvance);
                break;
            case CommandTypes::BACK:
                $capacityDischargeUnit = $this->actionBack($this->actionBack);
                break;
            case CommandTypes::CLEAN:
                $capacityDischargeUnit = $this->actionClean($this->actionClean);
                break;
            case CommandTypes::TURN_RIGHT:
                $capacityDischargeUnit = $this->actionRight($this->actionRight);
                break;
            case CommandTypes::TURN_LEFT:
                $capacityDischargeUnit = $this->actionLeft($this->actionLeft);
                break;
        }
        return $capacityDischargeUnit;
    }
}
