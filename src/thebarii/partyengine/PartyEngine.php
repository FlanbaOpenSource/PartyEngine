<?php

namespace thebarii\partyengine;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;
use pocketmine\plugin\ResourceProvider;
use pocketmine\Server;
use pocketmine\utils\CloningRegistryTrait;
use pocketmine\utils\SingletonTrait;
use thebarii\partyengine\party\PartyFactory;
use thebarii\partyengine\party\PartyMemberDisconnectListener;

class PartyEngine extends PluginBase
{
    use SingletonTrait;

    private PartyFactory $partyManager;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
       $this->partyManager = new PartyFactory();
       $this->registerListener(new PartyMemberDisconnectListener());

    }

    public function getPartyManager(): PartyFactory {

        return $this->partyManager;

    }

    private function registerListener(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

}