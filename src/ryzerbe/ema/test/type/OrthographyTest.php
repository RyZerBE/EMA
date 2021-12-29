<?php

namespace ryzerbe\ema\test\type;

use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ryzerbe\core\util\discord\DiscordMessage;
use ryzerbe\core\util\discord\embed\DiscordEmbed;
use ryzerbe\core\util\discord\embed\options\EmbedField;
use ryzerbe\ema\player\EMAPlayer;
use ryzerbe\ema\test\EMATest;
use function array_keys;
use function count;

class OrthographyTest extends EMATest {

    private array $sentences = [
        "DIE DEUTSCHE RECHDSCHRAIPUNG IST BEI MANCHEN PERSOHNEN KATERSTROFE" => "Die deutsche Rechtschreibung ist bei manchen Personen katastrophe."
    ];

    public function onStart(EMAPlayer $player): void{
        $sentences = $this->sentences;
        $form = new CustomForm(function(Player $player, $data) use ($sentences): void{
            if($data === null){
                $player->kick();
                return;
            }

            $rightSentence = 0;
            foreach(array_keys($sentences) as $sentence) {
                $writtenSentence = $data[$sentence] ?? null;
                if($writtenSentence === null) continue;
                if($writtenSentence === $sentences[$sentence]) $rightSentence++;
            }

            $message = new DiscordMessage("https://discord.com/api/webhooks/925704453225607200/dhrQnDK3fyToy4fGvqXzHfPA43Gi7sTDDnwTYJpiwq5fKEb4sVHELUVn1KCCmyw1c3bP");
            $embed = new DiscordEmbed();
            $embed->setTitle("Orthography Test Result");
            $embed->addField(new EmbedField("Player", $player->getName(), true));
            $embed->addField(new EmbedField("Correct Sentences", $rightSentence."/".count($this->sentences), true));
            $message->addEmbed($embed);
            $message->send();
        });

        $form->setTitle(TextFormat::GOLD."Orthographie Test");
        foreach(array_keys($this->sentences) as $sentence) $form->addInput($sentence, "", "", $sentence);
        $form->sendToPlayer($player->getPlayer());
    }

    public function onFinish(EMAPlayer $player): void{}

    public function onUpdate(int $currentTick): bool{
        return false;
    }
}