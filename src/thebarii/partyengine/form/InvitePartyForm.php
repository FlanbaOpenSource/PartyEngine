<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use sergittos\flanbacore\FlanbaCore;
use sergittos\flanbacore\session\SessionFactory;
use thebarii\partyengine\party\Party;
use thebarii\partyengine\party\PartyInvitation;
use thebarii\partyengine\PartyEngine;

class InvitePartyForm extends SimpleForm
{

    private Party $party;

    public function __construct(Party $party)
    {
        $this->party = $party;
        parent::__construct("Players");
    }

    public function onCreation(): void
    {

        foreach(FlanbaCore::getInstance()->getServer()->getOnlinePlayers() as $invitePlayer) {
            $button = new Button($invitePlayer->getName());
            $button->setSubmitListener(

                function() use ($invitePlayer) {

                    $invitation = new PartyInvitation($this->party->getName(), SessionFactory::getSession($invitePlayer));
                    PartyEngine::getInstance()->getPartyManager()->addInvitation($invitation);

                });

            $this->addButton($button);
        }
    }

}