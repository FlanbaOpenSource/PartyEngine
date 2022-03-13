<?php

namespace thebarii\partyengine\party;

use pocketmine\player\Player;
use sergittos\flanbacore\session\Session;

class PartyFactory
{

    /**
     * @var Party[]
     */
    private array $parties = [];
    private array $inPartyPlayers = [];
    private array $invitations = [];

    public function create(Session $owner, string $name): Party {

        $party = new Party($owner, $name);
        $this->parties[$name] = $party;
        $this->inPartyPlayers[$owner->getUsername()] = $name;

        return $party;
    }

    public function delete(string $name) {

        if(array_key_exists($name, $this->parties)) {

            foreach($this->parties[$name]->getPlayers() as $player)
                $player->message("Party disbanded.");

            unset($this->parties[$name]);
        }
    }

    public function addInvitation(PartyInvitation $invitation) {

        $this->invitations[$invitation->getInvitingSession()->getUsername() . $invitation->getPartyName()] = $invitation;
        $invitation->getInvitingSession()->getPlayer()->sendMessage("You got an invite from this party: " . $invitation->getPartyName());

    }

    public function removeInvitation(PartyInvitation $invitation) {

        unset($this->invitations[$invitation->getInvitingSession()->getUsername()]);
        $this->inPartyPlayers[$invitation->getInvitingSession()->getUsername()] = $invitation->getPartyName();

    }

    public function removePlayerFromPartyList(Session $session) {

        unset($this->inPartyPlayers[$session->getUsername()]);
    }

    /**
     * @return PartyInvitation[]
     */
    public function getInvitations(): array {

        return $this->invitations;

    }

    /**
     * @return Party[]
     */
    public function getParties(): array {
        return $this->parties;
    }

    public function getPartyByName(string $name): ?Party {

        return $this->parties[$name] ?? null;

    }

    public function isPlayerInParty(Player $player): bool {

        return array_key_exists($player->getName(), $this->inPartyPlayers);

    }

    public function getPartyOfPlayer(Session $session): ?Party
    {

        return $this->getPartyByName($this->inPartyPlayers[$session->getUsername()]);

    }

}