<?php

namespace thebarii\partyengine\form;

use EasyUI\element\Input;
use EasyUI\utils\FormResponse;
use EasyUI\variant\CustomForm;
use pocketmine\player\Player;
use sergittos\flanbacore\session\SessionFactory;
use thebarii\partyengine\PartyEngine;

class CreatePartyForm extends CustomForm
{
    public function __construct() {
        parent::__construct("Create party");
    }

    protected function onCreation(): void {

        $this->addElement("party name", new Input("Party name:"));

    }

    protected function onSubmit(Player $player, FormResponse $response): void {

        $partyName = $response->getInputSubmittedText("party name");
        $party = PartyEngine::getInstance()->getPartyManager()->create(SessionFactory::getSession($player), $partyName);
        $player->sendForm(new YourPartyForm($party, $player));

    }

}