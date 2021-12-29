<?php

namespace ryzerbe\ema;

use pocketmine\plugin\PluginBase;
use ryzerbe\core\util\loader\ListenerDirectoryLoader;
use ryzerbe\ema\scheduler\EMATask;

class Loader extends PluginBase {

    public function onEnable(){
        ListenerDirectoryLoader::load($this, $this->getFile(), __DIR__ . "/listener/");
        $this->getScheduler()->scheduleRepeatingTask(new EMATask(), 1);
    }
}