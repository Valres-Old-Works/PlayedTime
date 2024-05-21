<?php

namespace Valres\PlayedTime;

use JsonException;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Valres\PlayedTime\commands\TopPlayedTimeCommand;
use Valres\PlayedTime\listeners\PlayerJoin;
use Valres\PlayedTime\managers\PlayedTimeManager;

class PlayedTime extends PluginBase
{
    use SingletonTrait;

    public PlayedTimeManager $manager;

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->saveResource("datas.yml");

        $this->manager = new PlayedTimeManager($this);
        $this->manager->load();

        $this->getServer()->getCommandMap()->register("playedtime", new TopPlayedTimeCommand());
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoin(), $this);

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            foreach($this->manager->getAll() as $name => $playedtime){
                $player = Server::getInstance()->getPlayerExact($name);
                if($player instanceof Player and $player->isConnected()) $this->manager->addSecond($name);
            }
        }), 20);
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    /** @throws JsonException */
    protected function onDisable(): void {
        $this->manager->save();
    }
}
