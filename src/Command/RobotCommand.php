<?php

declare(strict_types=1);

namespace App\Command;

use App\Entities\InputSettingEntity;
use App\Entities\PositionEntity;
use App\Entities\RobotEntity;
use App\Services\RobotService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Exception\RobotImpossibleMoveException;
use App\Exception\ZeroBatteryException;

class RobotCommand extends Command
{
    private RobotService $robotService;

    private SerializerInterface $serializer;

    /**
     * RobotCommand constructor.
     *
     * @param RobotService $robotService
     * @param SerializerInterface $serializer
     */
    public function __construct(RobotService $robotService, SerializerInterface $serializer)
    {
        $this->robotService = $robotService;
        $this->serializer = $serializer;
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this->setName('robot:run')
            ->addArgument('source', InputArgument::OPTIONAL, 'Path to input parameters json file')
            ->addArgument('result', InputArgument::OPTIONAL, 'Path to result json file');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws RobotImpossibleMoveException
     * @throws ZeroBatteryException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathInputFile = $this->getPathFile($input, '/../../sources/source.json');
        $pathOutputFile = $this->getPathFile($input, '/../../sources/result.json');

        $cleanRobot = $this->createRobot($pathInputFile);

        $outputLog = $this->robotService->handle($cleanRobot);

        $finalPosition = $this->setFinalPosition($cleanRobot);
        $outputLog->setFinal($finalPosition);
        $outputLog->setBattery($cleanRobot->getChargingOfBattery());

        $outputResult = $this->serializer->serialize(
            $outputLog,
            JsonEncoder::FORMAT,
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );

        $output->writeln($outputResult);

        file_put_contents($pathOutputFile, $outputResult);


        return Command::SUCCESS;
    }

    private function createRobot(string $pathInputFile): RobotEntity
    {
        $jsonParams = file_get_contents($pathInputFile);

        /**
         * @var InputSettingEntity $inputSetting
         */
        $inputSetting = $this->serializer->deserialize(
            $jsonParams,
            InputSettingEntity::class,
            JsonEncoder::FORMAT
        );

        return $this->buildRobotEntity($inputSetting);
    }

    /**
     * @param RobotEntity $cleanRobot
     * @return PositionEntity
     */
    private function setFinalPosition(RobotEntity $cleanRobot): PositionEntity
    {
        $finalPosition = new PositionEntity();
        $finalPosition->setY($cleanRobot->getPosY());
        $finalPosition->setX($cleanRobot->getPosX());
        $finalPosition->setFacing($cleanRobot->getDirection());

        return $finalPosition;
    }

    /**
     * @param InputInterface $input
     * @param string $defaultPath
     *
     * @return string
     */
    private function getPathFile(InputInterface $input, string $defaultPath): string
    {
        $path = $input->getArgument('source');

        if ($path === null) {
            $path = __DIR__ . $defaultPath;
        }

        return $path;
    }

    /**
     * @param InputSettingEntity $inputSetting
     * @return RobotEntity
     */
    private function buildRobotEntity(InputSettingEntity $inputSetting): RobotEntity
    {
        $robotEntity = new RobotEntity();
        $robotEntity->setPosX($inputSetting->getStart()->getX());
        $robotEntity->setPosY($inputSetting->getStart()->getY());
        $robotEntity->setDirection($inputSetting->getStart()->getFacing());
        $robotEntity->setChargingOfBattery($inputSetting->getBattery());
        $robotEntity->setMap($inputSetting->getMap());
        $robotEntity->setCommand($inputSetting->getCommands());

        return $robotEntity;
    }
}
