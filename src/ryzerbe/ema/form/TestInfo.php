<?php

namespace ryzerbe\ema\form;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ryzerbe\core\RyZerBE;
use ryzerbe\ema\player\EMAPlayer;
use ryzerbe\ema\test\EMATestManager;
use function implode;

class TestInfo {

    public static function onOpen(Player $player){
        $form = new SimpleForm(function(Player $player, $data): void{
            $emaPlayer = new EMAPlayer($player);
            EMATestManager::getInstance()->addPlayer($emaPlayer);
            OrthographyTestInfo::onOpen($player);
        });

        $form->setTitle(TextFormat::BLUE."Staff EMA");
        $form->setContent(implode("\n".TextFormat::WHITE, [
            "Willkommen im Staff Auswahlverfahren auf dem ".RyZerBE::PREFIX.TextFormat::YELLOW."Network",
            "",
            "In diesem Test wirst du gründlich unter die Lupe genommen. Dieser Auswahltest wurde entwickelt, da sich viele für den Staff Rang bewerben und wir nur die Besten brauchen!",
            "Dieser Test teilt sich in drei Abschnitte:",
            TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Auswahlinterview §8(§aBESTANDEN§8)",
            TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Orthographie Test",
            TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Fähigkeitstest",
            "",
            "Der Auswahltest hat §c§lkein K.O System§r§f. Das bedeutet, du durchläufst §aalle Testabschnitte§f, obwohl du es vielleicht §cnicht bestanden §fhast.",
            "Du erhältst bei §ajedem Testabschnitt §feine §aErklärung§f, also keine Sorge! Sobald du die §eErklärung wegklickst, startet der Test§c!",
            "",
            "§c§lEs sind keine Hilfsmittel erlaubt! Die Benutzung von Hilfsmitteln führen zum PERMANENTEN Auschluss unseres Teams!",
            "",
            "Wir wünschen Dir jetzt §aviel Erfolg §fund ein §agutes Gelingen§c!"
        ]));
        $form->addButton(TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Ich habe alles verstanden");
        $form->sendToPlayer($player);
    }
}