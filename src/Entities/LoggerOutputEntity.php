<?php

declare(strict_types=1);

namespace App\Entities;

final class LoggerOutputEntity
{
    private int $battery;

    /**
     * @var PositionEntity[]
     */
    private array $visited = [];

    /**
     * @var PositionEntity[]
     */
    private array $cleaned = [];

    private PositionEntity $final;

    /**
     * @return PositionEntity[]
     */
    public function getVisited(): array
    {
        return $this->visited;
    }

    /**
     * @param PositionEntity[] $visited
     */
    public function setVisited(array $visited): void
    {
        $this->visited = $visited;
    }

    /**
     * @param PositionEntity $position
     */
    public function addVisited(PositionEntity $position): void
    {
        $this->visited[] = $position;
    }

    /**
     * @return PositionEntity[]
     */
    public function getCleaned(): array
    {
        return $this->cleaned;
    }

    /**
     * @param PositionEntity[] $cleaned
     */
    public function setCleaned(array $cleaned): void
    {
        $this->cleaned = $cleaned;
    }

    /**
     * @param PositionEntity $position
     */
    public function addCleaned(PositionEntity $position): void
    {
        $this->cleaned[] = $position;
    }

    /**
     * @return PositionEntity
     */
    public function getFinal(): PositionEntity
    {
        return $this->final;
    }

    /**
     * @param PositionEntity $position
     */
    public function setFinal(PositionEntity $position)
    {
        $this->final = $position;
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
}
