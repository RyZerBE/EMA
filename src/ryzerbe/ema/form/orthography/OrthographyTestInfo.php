<?php

namespace ryzerbe\ema\form;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ryzerbe\ema\test\EMATestManager;
use ryzerbe\ema\test\type\OrthographyTest;
use function implode;

class OrthographyTestInfo {

    public static function onOpen(Player $player){
        $form = new SimpleForm(function(Player $player, $data): void{
            $emaPlayer = EMATestManager::getInstance()->getPlayer($player);
            if($emaPlayer === null) return;

            $emaPlayer->startTest(new OrthographyTest());
        });

        $form->setTitle(TextFormat::GOLD."Orthographie Test");
        $form->setContent(implode("\n".TextFormat::WHITE, [
            "Wir starten mit der Testung deiner Deutschfähigkeiten.",
            "Als Staff ist es wichtig, eine ordentliche Orthographie zu besitzen.",
            "",
            "§c§lErklärung:",
            "",
            "Du erhältst gleich ein UI, in dem Sätze vorgegeben sind. Diese Sätze sind allerdings falsch geschrieben und Deine Aufgabe ist es, die Sätze korrigiert in das Feld eintragen.",
            "",
            "§f§lBeispiel:",
            "",
            "ICH BIN EIN GUTHER SUPPORTER DEN ICH HAPE EINE ORDENTLICHE ORTHOGRAPI",
            "",
            "Du müsstest den Satz jetzt korrigiert so eintragen:",
            "§aRICHTIG: §fIch bin ein guter Staff, denn ich habe eine ordentliche Orthographie.",
            "",
            "Alles verstanden? Wenn ja, dann atme noch einmal durch und Let's Go!"
        ]));
        $form->addButton(TextFormat::DARK_GRAY."» ".TextFormat::GREEN."Test starten");
        $form->sendToPlayer($player);
    }
}