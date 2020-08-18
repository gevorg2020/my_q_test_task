<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entities\RobotEntity;
use App\Exception\ZeroBatteryException;
use App\Exception\RobotImpossibleMoveException;
use App\Services\RobotService;
use Error;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommonTest extends KernelTestCase
{
    /**
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    public function testWithoutStartParams()
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
        $robot->setCommand($command);
        $robot->setMap($map);
        $robot->setDirection('N');

        self::bootKernel();
        /**
         * @var RobotService $cleanRobotService
        */
        $cleanRobotService = static::$kernel->getContainer()->get(RobotService::class);
        $this->expectException(Error::class);
        $cleanRobotService->handle($robot);
    }

    /**
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    public function testWrongStartParams()
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
        $robot->setCommand($command);
        $robot->setMap($map);
        $robot->setPosX(30);
        $robot->setPosY(100);
        $robot->setDirection('N');

        self::bootKernel();
        /**
         * @var RobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(RobotService::class);
        $this->expectExceptionMessage('Robot stuck');
        $cleanRobotService->handle($robot);
    }

    /**
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    public function testRobotStuck()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["C", "C", "S", "C"],
            ["C", "C", "C", "C"],
            ["C", "C", "C", "C"],
            ["S", null, "S", "S"]
        ];

        $robot = new RobotEntity();
        $robot->setChargingOfBattery(80);
        $robot->setCommand($command);
        $robot->setMap($map);
        $robot->setPosX(3);
        $robot->setPosY(0);
        $robot->setDirection('N');

        self::bootKernel();
        /**
         * @var RobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(RobotService::class);
        $this->expectException(RobotImpossibleMoveException::class);
        $cleanRobotService->handle($robot);
    }

    /**
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    public function testBatteryIsLow()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $robot = new RobotEntity();
        $robot->setChargingOfBattery(0);
        $robot->setPosX(3);
        $robot->setPosY(0);
        $robot->setCommand($command);
        $robot->setMap($map);
        $robot->setDirection('N');

        self::bootKernel();
        /**
         * @var RobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(RobotService::class);
        $this->expectException(ZeroBatteryException::class);
        $cleanRobotService->handle($robot);
    }
}
