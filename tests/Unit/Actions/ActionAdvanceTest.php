<?php

declare(strict_types=1);

namespace App\Tests\Unit\Actions;

use App\Exception\WrongMapPointException;
use App\Services\LoggerService;
use App\Services\MapService;
use App\Strategy\Actions\AdvanceAction;

class ActionAdvanceTest extends AbstractAction
{
    private AdvanceAction $action;

    protected function setUp(): void
    {
        $mapServiceMock = $this->createMock(MapService::class);
        $loggerServiceMock = $this->createMock(LoggerService::class);
        $this->action = new AdvanceAction($mapServiceMock);
        $this->action->setLoggerService($loggerServiceMock);
        parent::setUp();
    }

    /**
     * @throws WrongMapPointException
     */
    public function testWithWrongStartPoint()
    {
        $this->robot->setPosX(0);
        $this->robot->setPosY(-1);
        $this->expectException(WrongMapPointException::class);
        $this->action->run($this->robot);
    }
}
