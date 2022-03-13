<?php

namespace thebarii\partyengine\party;

use sergittos\flanbacore\session\Session;

class PartyInvitation
{

    private string $partyName;
    private Session $session;

    public function __construct(string $partyName, Session $session) {

        $this->partyName = $partyName;
        $this->session = $session;

    }

    public function getPartyName(): string
    {

        return $this->partyName;

    }

    public function getInvitingSession(): Session
    {

        return $this->session;

    }

}