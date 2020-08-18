<?php

declare(strict_types=1);

namespace App\Strategy\Actions\Contracts;

use App\Entities\RobotEntity;
use App\Services\LoggerService;

interface ActionWithLogger extends ActionInterface
{
    /**
     * @return LoggerService
     */
    public function getLoggerService(): LoggerService;

    /**
     * @param LoggerService $loggerService
     */
    public function setLoggerService(LoggerService $loggerService): void;
}
