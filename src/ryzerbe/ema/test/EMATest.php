<?php

namespace ryzerbe\ema\test;

use pocketmine\event\Listener;
use ryzerbe\ema\player\EMAPlayer;

abstract class EMATest implements Listener {

    abstract public function onStart(EMAPlayer $player): void;
    abstract public function onFinish(EMAPlayer $player): void;

    abstract public function onUpdate(int $currentTick): bool;
}