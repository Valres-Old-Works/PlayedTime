<?php

namespace Valres\PlayedTime\listeners;

use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Valres\PlayedTime\PlayedTime;

class PlayerJoin implements Listener
{
    /**@throws JsonException */
    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $plugin = PlayedTime::getInstance();
        $name = $event->getPlayer()->getName();

        if(!$plugin->manager->exist($name)) $plugin->manager->init($name);
    }
}
