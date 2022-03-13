<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;
use sergittos\flanbacore\session\SessionFactory;
use thebarii\partyengine\PartyEngine;

class PartyInvitesForm extends SimpleForm
{
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
        parent::__construct("Invites");
    }

    public function onCreation(): void
    {
        foreach(PartyEngine::getInstance()->getPartyManager()->getInvitations() as $invitation) {

            if($invitation->getInvitingSession()->getUsername() === $this->player->getName()) {

                $player = $this->player;
                $button = new Button($invitation->getPartyName());
                $button->setSubmitListener(

                    function () use ($invitation, $player) {

                        $party = PartyEngine::getInstance()->getPartyManager()->getPartyByName($invitation->getPartyName());
                        $party->add(SessionFactory::getSession($player));
                        PartyEngine::getInstance()->getPartyManager()->removeInvitation($invitation);
                    });

                $this->addButton($button);

            }

        }
    }

}