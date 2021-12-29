<?php

namespace ryzerbe\ema\player;

use pocketmine\Player;
use ryzerbe\ema\test\EMATest;

class EMAPlayer {

    private ?EMATest $actualTest = null;

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
        $this->actualTest = $actualTest;

        $actualTest?->onStart($this);
        $this->actualTest?->onFinish($this);
    }
}