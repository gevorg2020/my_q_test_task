<?php

declare(strict_types=1);

namespace App\Types;

use App\Factory\CleanRobotCommand\AdvanceCommand;
use App\Factory\CleanRobotCommand\BackCommand;
use App\Factory\CleanRobotCommand\CleanCommand;
use App\Factory\CleanRobotCommand\TurnLeftCommand;
use App\Factory\CleanRobotCommand\TurnRightCommand;

class CommandTypes
{
    public const TURN_LEFT = 'TL';

    public const TURN_RIGHT = 'TR';

    public const ADVANCE = 'A';

    public const BACK = 'B';

    public const CLEAN = 'C';


    public const STEP_BACK_STRATEGY = [
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_LEFT],
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_RIGHT],
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_RIGHT],
        [self::TURN_RIGHT, self::BACK, self::TURN_RIGHT, self::ADVANCE],
        [self::TURN_LEFT, self::TURN_LEFT, self::ADVANCE],
    ];
}
