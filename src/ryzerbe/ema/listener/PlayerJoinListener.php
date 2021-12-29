<?php

namespace ryzerbe\ema\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use ryzerbe\core\util\async\AsyncExecutor;
use ryzerbe\core\util\TaskUtils;
use ryzerbe\ema\form\TestInfo;

class PlayerJoinListener implements Listener {

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $event->setJoinMessage("");
        $player->setGamemode(3);
        AsyncExecutor::submitClosureTask(TaskUtils::secondsToTicks(3), function(int $currentTick) use ($player): void{
            if(!$player->isConnected()) return;

            TestInfo::onOpen($player);
        });
    }
}