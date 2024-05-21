<?php

namespace Valres\PlayedTime\managers;

use JsonException;
use pocketmine\utils\Config;
use Valres\PlayedTime\PlayedTime;

class PlayedTimeManager
{
    /** @var int[] */
    private array $players = [];
    private Config $datas;

    public function __construct(private readonly PlayedTime $plugin) {
        $this->datas = new Config($this->plugin->getDataFolder() . "datas.yml", Config::YAML);
    }

    public function getTime(string $name): ?int {
        return $this->players[$name] ?? null;
    }

    public function getAll(): array {
        return $this->players;
    }

    public function exist(string $name): bool {
        return array_key_exists($name, $this->players);
    }

    public function addSecond(string $name): void {
        $this->players[$name]++;
    }

    public function load(): void {
        foreach($this->datas->getAll() as $name => $playedtime){
            $this->players[$name] = $playedtime;
        }
    }

    /** @throws JsonException */
    public function save(): void {
        foreach($this->players as $name => $playedtime){
            $this->datas->set($name, $playedtime);
        }
        $this->datas->save();
    }

    /** @throws JsonException */
    public function init(string $name): void {
        $this->datas->set($name, 0);
        $this->datas->save();

        $this->players[$name] = 0;
    }
}
