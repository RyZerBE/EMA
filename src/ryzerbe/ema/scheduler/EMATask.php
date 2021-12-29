<?php

namespace ryzerbe\ema\scheduler;

use pocketmine\scheduler\Task;
use ryzerbe\ema\test\EMATestManager;

class EMATask extends Task {

    public function onRun(int $currentTick){
        foreach(EMATestManager::getInstance()->getTests() as $test) {
            if(!$test->onUpdate($currentTick)) continue;

            $test->onUpdate($currentTick);
        }
    }
}