<?php

namespace ryzerbe\ema\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use ryzerbe\core\util\ItemUtils;
use ryzerbe\ema\form\SillTestEMAForm;
use ryzerbe\ema\test\EMATestManager;

class PlayerInteractListener implements Listener {

    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $emaPlayer = EMATestManager::getInstance()->getPlayer($player);
        if($emaPlayer === null) return;
        if(!ItemUtils::hasItemTag($item, "replay_item")) return;
        $player->resetItemCooldown($item, 20);

        switch(ItemUtils::getItemTag($item, "replay_item")) {
            case "ema":
                SillTestEMAForm::onOpen($emaPlayer);
                break;
        }
    }
}