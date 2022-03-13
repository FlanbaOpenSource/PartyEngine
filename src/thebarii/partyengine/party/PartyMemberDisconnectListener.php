<?php

namespace thebarii\partyengine\party;

use JetBrains\PhpStorm\Pure;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use sergittos\flanbacore\session\SessionFactory;
use thebarii\partyengine\PartyEngine;

class PartyMemberDisconnectListener implements Listener
{
    #[Pure] public function onLeave(PlayerQuitEvent $event) {

        $player = $event->getPlayer();

        if(PartyEngine::getInstance()->getPartyManager()->isPlayerInParty($player)) {

            $party = PartyEngine::getInstance()->getPartyManager()->getPartyOfPlayer(SessionFactory::getSession($player));

            if($party->isOwner($player))
                PartyEngine::getInstance()->getPartyManager()->delete($party->getName());
            else $party->remove(SessionFactory::getSession($player));

        }

    }

}