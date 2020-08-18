<?php

declare(strict_types=1);

namespace App\Strategy\Actions\Contracts;

use App\Entities\RobotEntity;

interface ActionInterface
{
    public function run(RobotEntity $robotEntity): int;
}
