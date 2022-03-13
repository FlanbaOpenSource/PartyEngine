<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;
use thebarii\partyengine\party\Party;

class PlayersInPartyForm extends SimpleForm
{
    public Party $party;
    public Player $player;

    public function __construct(Party $party, Player $player)
    {
        $this->party = $party;
        $this->player = $player;
        parent::__construct("Players / Party");
    }

    public function onCreation(): void
    {

        $player = $this->player;
        $party = $this->party;

        foreach($this->party->getPlayers() as $session) {

            $button = new Button($session->getUsername());

            if($party->isOwner($player)) {

                $button->setSubmitListener(

                    function () use ($player, $party, $session) {

                        $player->sendForm(new ModifyPlayerInPartyForm($session, $player, $party));

                    });

            }

            $this->addButton($button);

        }
    }

}