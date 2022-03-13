<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use pocketmine\player\Player;
use sergittos\flanbacore\session\Session;
use sergittos\flanbacore\session\SessionFactory;
use thebarii\partyengine\form\CreatePartyForm;
use thebarii\partyengine\PartyEngine;

class PartyForm extends \EasyUI\variant\SimpleForm
{

     private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
        parent::__construct("Parties");
    }

    public function onCreation(): void
    {
        $createButton = new Button("Create Party");
        $invitesButton = new Button("Party Invites");
        $player = $this->player;

        if(!PartyEngine::getInstance()->getPartyManager()->isPlayerInParty($player)) {
            $createButton->setSubmitListener(

                function () use ($player) {
                    $player->sendForm(new CreatePartyForm());

                });

            $invitesButton->setSubmitListener(

                function () use ($player) {
                    $player->sendForm(new PartyInvitesForm($player));

                });

            $this->addButton($createButton);
            $this->addButton($invitesButton);

        } else {

            $button = new Button("Your Party");
            $leaveButton = new Button("Leave your party.");

            $leaveButton->setSubmitListener(

                function () use ($player) {

                    $session = SessionFactory::getSession($player);
                    $session->message("You left the party!");

                    $party = PartyEngine::getInstance()->getPartyManager()->getPartyOfPlayer($session);
                    $party->remove($session, true);

                });

            $button->setSubmitListener(

                function () use ($player) {

                    $player->sendForm(new YourPartyForm(PartyEngine::getInstance()->getPartyManager()->getPartyOfPlayer(SessionFactory::getSession($player)), $player));

                });

           $this->addButton($button);

        }
    }

}