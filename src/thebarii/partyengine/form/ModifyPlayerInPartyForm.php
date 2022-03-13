<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;
use sergittos\flanbacore\session\Session;
use thebarii\partyengine\party\Party;

class ModifyPlayerInPartyForm extends SimpleForm {

    private Session $session;
    private Party $party;
    private Player $player;

    public function __construct(Session $session, Player $player, Party $party)
    {
        $this->session = $session;
        $this->party = $party;
        $this->player = $player;
        parent::__construct($session->getUsername());
    }

    public function onCreation(): void
    {
        $session = $this->session;
        $party = $this->party;
        $setOwnerButton = new Button("Set as owner");
        $kickPlayerButton = new Button("Kick player");

        $setOwnerButton->setSubmitListener(

            function () use ($session, $party) {

                $party->setOwner($session);

                foreach($party->getPlayers() as $player)
                    $player->message($session->getUsername() . " is now the party owner.");

            });

        $kickPlayerButton->setSubmitListener(

            function () use ($session, $party){

                $party->remove($session);

                foreach($party->getPlayers() as $player)
                    $player->message($session->getUsername() . " is now the party owner.");

           });

        if($party->isOwner($this->player)) {

            $this->addButton($kickPlayerButton);
            $this->addButton($setOwnerButton);

        }
    }


}