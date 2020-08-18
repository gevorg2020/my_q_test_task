<?php

declare(strict_types=1);

namespace App\Tests\Unit\Actions;

use App\Services\MapService;
use App\Strategy\Actions\LeftAction;

class ActionLeftTest extends AbstractAction
{
    private LeftAction $action;

    protected function setUp(): void
    {
        $mapServiceMock = $this->createMock(MapService::class);
        $this->action = new LeftAction($mapServiceMock);
        parent::setUp();
    }


    public function testLeft()
    {
        $this->action->run($this->robot);
        $this->assertEquals('W', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertEquals('S', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertEquals('E', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertEquals('N', $this->robot->getDirection());
    }

    public function testWrongLeft()
    {
        $this->action->run($this->robot);
        $this->assertNotEquals('N', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertNotEquals('W', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertNotEquals('S', $this->robot->getDirection());
        $this->action->run($this->robot);
        $this->assertNotEquals('E', $this->robot->getDirection());
    }
}
