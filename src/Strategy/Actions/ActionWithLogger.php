<?php


declare(strict_types=1);

namespace App\Strategy\Actions;

use App\Services\LoggerService;

abstract class ActionWithLogger implements Contracts\ActionWithLogger
{

    private LoggerService $loggerService;

    /**
     * @return LoggerService
     */
    public function getLoggerService(): LoggerService
    {
        return $this->loggerService;
    }

    /**
     * @param LoggerService $loggerService
     */
    public function setLoggerService(LoggerService $loggerService): void
    {
        $this->loggerService = $loggerService;
    }
}
