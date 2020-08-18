<?php

declare(strict_types=1);

namespace App\Services;

use App\Types\CommandTypes;
use App\Entities\LoggerOutputEntity;
use App\Entities\RobotEntity;
use App\Exception\WrongMapPointException;
use App\Exception\RobotImpossibleMoveException;
use App\Exception\ZeroBatteryException;
use App\Strategy\RobotStrategy;

class RobotService
{
    private BatteryService $batteryService;

    /**
     * @var RobotStrategy
     */
    private RobotStrategy $robotStrategy;

    /**
     * @var LoggerService
     */
    private LoggerService $loggerService;

    /**
     * RobotService constructor.
     *
     * @param BatteryService $batteryService
     * @param LoggerService $loggerService
     * @param RobotStrategy $robotStrategy
     */
    public function __construct(
        BatteryService $batteryService,
        LoggerService $loggerService,
        RobotStrategy $robotStrategy
    ) {
        $this->batteryService = $batteryService;
        $this->loggerService = $loggerService;
        $this->robotStrategy = $robotStrategy;
    }


    /**
     * @param RobotEntity $robotEntity
     *
     * @return LoggerOutputEntity
     *
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    public function handle(RobotEntity $robotEntity): LoggerOutputEntity
    {
        foreach ($robotEntity->getCommand() as $command) {
            try {
                $this->execute($robotEntity, $command);
            } catch (WrongMapPointException $e) {
                $this->tryGoBackStrategies($robotEntity, $command);
            }
        }

        return $this->loggerService->getLoggerOutput();
    }

    /**
     * @param RobotEntity $robotEntity
     *
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    private function tryGoBackStrategies(RobotEntity $robotEntity, string $initialCommand): void
    {
        $commandStrategy = CommandTypes::STEP_BACK_STRATEGY;
        foreach ($commandStrategy as $strategy) {
            try {
                foreach ($strategy as $command) {
                    $this->execute($robotEntity, $command);
                }
                $this->execute($robotEntity, $initialCommand);
                return;
            } catch (WrongMapPointException $e) {
                continue;
            }
        }
        throw new RobotImpossibleMoveException('Robot stuck');
    }


    /**
     * @param RobotEntity $robotEntity
     * @param string        $command
     *
     * @throws ZeroBatteryException
     */
    private function execute(RobotEntity $robotEntity, string $command): void
    {
        $this->robotStrategy->setRobotEntity($robotEntity);
        $unitOfDischarge = $this->robotStrategy->execute($command);
        $this->batteryService->dicreeseBattaryCharge($robotEntity, $unitOfDischarge);
    }
}
