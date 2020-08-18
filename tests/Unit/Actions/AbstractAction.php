<?php

declare(strict_types=1);

namespace App\Tests\Unit\Actions;

use App\Entities\RobotEntity;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AbstractAction extends KernelTestCase
{
    protected RobotEntity $robot;

    protected function setUp(): void
    {
        $this->robot = $this->buildRobot();
    }

    private function buildRobot()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $robot = new RobotEntity();
        $robot->setChargingOfBattery(80);
        $robot->setPosX(3);
        $robot->setPosY(0);
        $robot->setCommand($command);
        $robot->setMap($map);
        $robot->setDirection('N');

        return $robot;
    }
}
