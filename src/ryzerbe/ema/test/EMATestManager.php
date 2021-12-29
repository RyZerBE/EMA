<?php

namespace ryzerbe\ema\test;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use ryzerbe\core\RyZerBE;
use ryzerbe\ema\player\EMAPlayer;
use ryzerbe\ema\test\type\OrthographyTest;

class EMATestManager {
    use SingletonTrait;

    /** @var EMATest[]  */
    private array $tests = [];
    /** @var EMAPlayer[] */
    private array $players = [];

    public function __construct(){
        self::registerTests(
            new OrthographyTest()
        );
    }

    public function addPlayer(EMAPlayer $player){
        $this->players[$player->getPlayer()->getName()] = $player;
    }

    public function removePlayer(EMAPlayer|Player $player){
        unset($this->players[$player->getPlayer()->getName()]);
    }

    /**
     * @param string|Player $player
     * @return EMAPlayer|null
     */
    public function getPlayer(string|Player $player): ?EMAPlayer{
        if($player instanceof Player) $player = $player->getName();

        return $this->players[$player] ?? null;
    }

    public function registerTest(EMATest $test): void{
        Server::getInstance()->getPluginManager()->registerEvents($test, RyZerBE::getPlugin());
        if(isset($this->tests[$test::class])) return;

        $this->tests[$test::class] = $test;
    }

    public function registerTests(EMATest... $tests): void{
        foreach($tests as $test) $this->registerTest($test);
    }

    public function isTestRegistered(EMATest $test): bool{
        return isset($this->tests[$test::class]);
    }

    /**
     * @return EMATest[]
     */
    public function getTests(): array{
        return $this->tests;
    }
}