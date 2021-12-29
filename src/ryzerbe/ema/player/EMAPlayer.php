<?php

namespace ryzerbe\ema\player;

use matze\replaysystem\player\form\ChooseOptionForm;
use matze\replaysystem\player\form\PlayReplayForm;
use matze\replaysystem\player\Loader;
use matze\replaysystem\player\provider\ReplayProvider;
use matze\replaysystem\player\replay\Replay;
use matze\replaysystem\player\replay\ReplayManager;
use matze\replaysystem\player\scheduler\ReplayLoadTask;
use pocketmine\Player;
use pocketmine\Server;
use ryzerbe\ema\test\EMATest;
use ryzerbe\ema\test\type\SkillTest;
use function array_fill_keys;
use function array_keys;
use function array_rand;
use function array_search;
use function count;
use function is_null;

class EMAPlayer {

    private ?EMATest $actualTest = null;
    /** @var array  */
    private array $solvedReplays = [];
    private string $actualReplay = "";

    public function __construct(private Player $player){}

    /**
     * @return Player
     */
    public function getPlayer(): Player{
        return $this->player;
    }


    /**
     * @return EMATest|null
     */
    public function getActualTest(): ?EMATest{
        return $this->actualTest;
    }

    /**
     * @param EMATest|null $actualTest
     */
    public function startTest(?EMATest $actualTest): void{
        $this->actualTest?->onFinish($this);

        $this->actualTest = $actualTest;
        $actualTest?->onStart($this);
    }

    /**
     * @return array
     */
    public function getSolvedReplays(): array{
        return $this->solvedReplays;
    }

    /**
     * @param string $replayId
     * @param bool $hacks
     */
    public function solveReplay(string $replayId, bool $hacks){
        $this->solvedReplays[$replayId] = $hacks;
    }

    /**
     * @param bool $start
     * @return string|null
     */
    public function nextReplay(bool $start): ?string{
        $test = $this->getActualTest();
        if(!$test instanceof SkillTest) return null;

        $replayIds = array_keys($test::REPLAYS);
        foreach(array_keys($this->solvedReplays) as $replayId) {
            unset($replayIds[array_search($replayId, $replayIds)]);
        }

        if(count($replayIds) > 0){
            $replayId = $replayIds[array_rand($replayIds)];
            if($start) {
                $player = $this->getPlayer();
                $this->setActualReplay($replayId);
                ReplayManager::getInstance()->playReplay($replayId, function(Replay $replay) use ($player): void {
                    if(!$player->isConnected()) return;

                    Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new ReplayLoadTask($player, $replay), 2);
                });
            }
            return $replayId;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getActualReplay(): string{
        return $this->actualReplay;
    }

    /**
     * @param string|Replay $actualReplay
     */
    public function setActualReplay(string|Replay $actualReplay): void{
        if($actualReplay instanceof Replay) $actualReplay = $actualReplay->getId();
        $this->actualReplay = $actualReplay;
    }
}