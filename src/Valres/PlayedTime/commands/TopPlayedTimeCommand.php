<?php

namespace Valres\PlayedTime\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use Valres\PlayedTime\PlayedTime;
use Valres\PlayedTime\utils\TimeHelper;

class TopPlayedTimeCommand extends Command
{
    public function __construct() {
        parent::__construct("topplayedtime", "Show top played time players");
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        $plugin = PlayedTime::getInstance();

        $message = $plugin->getConfig()->get("top-title") . "\n";
        $top = $plugin->manager->getAll();
        arsort($top);
        $top_ = array_slice($top, 0, 10, true);
        $top = 0;
        foreach($top_ as $name => $playedtime){
            $top++;
            $message .= str_replace(
                ["{rank}", "{name}", "{time}"],
                [$top, $name, TimeHelper::convertToString($playedtime)],
                $plugin->getConfig()->get("top-lines")
            ) . "\n\n";
        }
        $message .= str_replace("{time}", TimeHelper::convertToString($plugin->manager->getTime($sender->getName())), $plugin->getConfig()->get("our-time"));
        $sender->sendMessage($message);
    }
}
