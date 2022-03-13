<?php

namespace thebarii\partyengine\party;

use pocketmine\player\Player;
use sergittos\flanbacore\session\Session;
use thebarii\partyengine\PartyEngine;

class Party
{

    private string $name;
    private Session $owner;
    /**
     * @var Session[]
     */
    private array $players;

    public function __construct(Session $owner, $name)
    {
        $this->name = $name;
        $this->players[$owner->getUsername()] = $owner;
        $this->owner = $owner;
    }


    public function add(Session $session) {

        $this->players[$session->getUsername()] = $session;
        $session->message("You entered " . $this->getName() . " owned by " . $this->getOwner()->getUsername());
        foreach($this->players as $player)
            $player->message($session->getUsername() . " joined the party.");

    }

    public function remove(Session $session, bool $onPurpose = false) {

        unset($this->players[$session->getUsername()]);
        PartyEngine::getInstance()->getPartyManager()->removePlayerFromPartyList($session);

        foreach($this->getPlayers() as $player)
            $player->message($session->getUsername() . " left the party.");

        if(!$onPurpose) {
            if ($session !== null and $session->getPlayer() !== null and $session->getPlayer()->isOnline())
                $session->message("You were removed from the party.");
        }

    }

    public function getOwner(): Session {

        return $this->owner;

    }

    public function getPlayers(): array {

        return $this->players;

    }

    public function getName(): string {

        return $this->name;

    }

    public function setOwner(Session $session) {

        $this->owner = $session;

    }

    public function isOwner(Player $player): bool {

        return $player->getName() === $this->owner->getUsername();

    }

    /**
     * Gets a player from the party by name.
     * @param string $username
     * @return Session|null
     */
    public function getPlayerByName(string $username): Session|null {

        return $this->players[$username] ?? null;

    }


}