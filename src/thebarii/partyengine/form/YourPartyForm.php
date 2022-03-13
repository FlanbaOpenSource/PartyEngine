<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;
use thebarii\partyengine\party\Party;
use thebarii\partyengine\PartyEngine;

class YourPartyForm extends SimpleForm {

    private Party $party;
    private Player $player;

    public function __construct(Party $party, Player $player) {

        $this->party = $party;
        $this->player = $player;
        parent::__construct("Your Party.");
    }

    public function onCreation(): void
    {


        $button = new Button("Invite Players");
        $playersButton = new Button("Players in Party");
        $disbandButton = new Button("Disband Party");
        $party = $this->party;
        $player = $this->player;

        $button->setSubmitListener(

            function () use ($player, $party) {

                $player->sendForm(new InvitePartyForm($party));

             });

        $playersButton->setSubmitListener(

            function () use ($player, $party) {

                $player->sendForm(new PlayersInPartyForm($party, $player));

            });

        $disbandButton->setSubmitListener(

            function () use ($player, $party) {

                foreach($party->getPlayers() as $player)
                    $player->message("Party disbanded.");

                PartyEngine::getInstance()->getPartyManager()->delete($party->getName());

            });

        if($party->isOwner($player)) {
            $this->addButton($disbandButton);
            $this->addButton($button);
        }

        $this->addButton($playersButton);
    }



}