<?php

declare(strict_types=1);

namespace App\Entities;

final class RobotEntity
{
    private string $direction;

    private int $chargingOfBattery;

    private int $posX;

    private int $posY;

    /**
     * @var string[]
     */
    private array $command;

    /**
     * @var int[][]
     */
    private array $map;

    /**
     * @return int
     */
    public function getPosX(): int
    {
        return $this->posX;
    }

    /**
     * @param int $posX
     */
    public function setPosX(int $posX): void
    {
        $this->posX = $posX;
    }

    /**
     * @return int
     */
    public function getPosY(): int
    {
        return $this->posY;
    }

    /**
     * @param int $posY
     */
    public function setPosY(int $posY): void
    {
        $this->posY = $posY;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function getChargingOfBattery(): int
    {
        return $this->chargingOfBattery;
    }

    /**
     * @param int $chargingOfBattery
     */
    public function setChargingOfBattery(int $chargingOfBattery): void
    {
        $this->chargingOfBattery = $chargingOfBattery;
    }

    /**
     * @return string[]
     */
    public function getCommand(): array
    {
        return $this->command;
    }

    /**
     * @param string[] $command
     */
    public function setCommand(array $command): void
    {
        $this->command = $command;
    }

    /**
     * @return int[][]
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param int[][] $map
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }
}
