<?php

namespace ryzerbe\ema\test\type;

use ryzerbe\core\player\PMMPPlayer;
use ryzerbe\core\util\discord\DiscordMessage;
use ryzerbe\core\util\discord\embed\DiscordEmbed;
use ryzerbe\core\util\discord\embed\options\EmbedField;
use ryzerbe\ema\player\EMAPlayer;
use ryzerbe\ema\test\EMATest;
use function count;

class SkillTest extends EMATest {

    public const REPLAYS = [
        "c312e3" => false //NO HACKS
    ];

    public function onStart(EMAPlayer $player): void{
        $player->nextReplay(true);
    }

    public function onFinish(EMAPlayer $player): void{
        $rightReplays = 0;
        foreach($player->getSolvedReplays() as $replayId => $hacks) {
            if(self::REPLAYS[$replayId] === $hacks) $rightReplays++;
        }

        $message = new DiscordMessage("https://discord.com/api/webhooks/925704453225607200/dhrQnDK3fyToy4fGvqXzHfPA43Gi7sTDDnwTYJpiwq5fKEb4sVHELUVn1KCCmyw1c3bP");
        $embed = new DiscordEmbed();
        $embed->setTitle("Skill Test Result");
        $embed->addField(new EmbedField("Player", $player->getPlayer()->getName(), true));
        $embed->addField(new EmbedField("Correct Replays", $rightReplays."/".count(self::REPLAYS), true));
        $message->addEmbed($embed);
        $message->send();
        /** @var PMMPPlayer $player */
        $player = $player->getPlayer();
        $player->kickFromProxy("&aDanke für Deine Teilnahme an unserem Auswahltest!\n&cWir melden uns bei Dir ;)");
    }

    public function onUpdate(int $currentTick): bool{
        return false;
    }
}