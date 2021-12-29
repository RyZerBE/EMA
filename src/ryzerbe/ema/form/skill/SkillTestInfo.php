<?php

namespace ryzerbe\ema\form\skill;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ryzerbe\ema\test\EMATestManager;
use ryzerbe\ema\test\type\SkillTest;
use function implode;

class SkillTestInfo {

    public static function onOpen(Player $player){
        $form = new SimpleForm(function(Player $player, $data): void{
            $emaPlayer = EMATestManager::getInstance()->getPlayer($player);
            if($emaPlayer === null) return;

            $emaPlayer->startTest(new SkillTest());
        });

        $form->setTitle(TextFormat::GOLD."Skill Test");
        $form->setContent(implode("\n".TextFormat::RESET.TextFormat::WHITE, [
            "Du hast den Orhtographie Test nun hinter dir. Nun testen wir Deine Moderatoren Skills.",
            "",
            "§c§lErklärung:",
            "",
            "Wir spielen dir gleich ein paar Replays ab und du musst erkennen, ob der mit \"§9Mysterious Player\" §fgekennzeichnete Spieler gegen unser Regelwerk verstößt.",
            "",
            "§f§lBeispiel:",
            "",
            "Du siehst einen Spieler mit verbotenen Skin, so nutzt du das EMA Item in deiner Hotbar und markierst das Replay als Regelverstoß. ",
            "Erkennst du keinen Regelverstoß, markierst du das Replay als Ordungsgemäß",
            "",
            "Alles verstanden? Wenn ja, dann ran an die Arbeit! "
        ]));
        $form->addButton(TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Skill Test starten");
        $form->sendToPlayer($player);
    }
}