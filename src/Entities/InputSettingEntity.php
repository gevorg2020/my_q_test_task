<?php

declare(strict_types=1);

namespace App\Entities;

final class InputSettingEntity
{
    private array $map;

    private array $commands;

    private int $battery;

    private PositionEntity $start;

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array $map
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }

    /**
     * @return PositionEntity
     */
    public function getStart(): PositionEntity
    {
        return $this->start;
    }

    /**
     * @param PositionEntity $start
     */
    public function setStart(PositionEntity $start): void
    {
        $this->start = $start;
    }

    /**
     * @return int
     */
    public function getBattery(): int
    {
        return $this->battery;
    }

    /**
     * @param int $battery
     */
    public function setBattery(int $battery): void
    {
        $this->battery = $battery;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }
}
