<?php

namespace ryzerbe\ema\form;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ryzerbe\ema\player\EMAPlayer;
use ryzerbe\ema\test\EMATestManager;
use ryzerbe\ema\test\type\SkillTest;
use function boolval;
use function strval;

class SillTestEMAForm {

    public static function onOpen(EMAPlayer $player){
        $form = new SimpleForm(function(Player $player, $data): void{
            if($data === null) return;

            $emaPlayer = EMATestManager::getInstance()->getPlayer($player);
            if($emaPlayer === null) return;

            $emaPlayer->solveReplay($emaPlayer->getActualReplay(), boolval($data));
            $nextReplayId = $emaPlayer->nextReplay(true);
            if($nextReplayId === null) {
                (new SkillTest())->onFinish($emaPlayer);
            }
        });
        $form->setTitle(TextFormat::BLUE."Staff EMA");
        $form->setContent("Hast du in dem Report einen Regelverstoß entdeckt?");
        $form->addButton(TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Regelverstoß erkannt", -1, "", strval(true));
        $form->addButton(TextFormat::DARK_GRAY."» ".TextFormat::RED."Kein Regelverstoß erkannt", -1, "", strval(false));
        $form->sendToPlayer($player->getPlayer());
    }
}