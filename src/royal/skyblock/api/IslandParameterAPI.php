<?php

namespace royal\skyblock\api;

use JsonException;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\skyblock\Main;

class IslandParameterAPI
{
    private $plugin;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getPlugin (): Main
    {
        return $this->plugin;
    }


    /**
     * @throws JsonException
     */
    public function createParameter ($player)
    {
        $parameter = [
            "Leader" => $player,
            "co-Leader" => [

            ],
            "Officer" => [

            ],
            "Members" => [

            ],
            "Experience" => 0,
            "Levels" => 0,
            "Visit" => false,
            "CreationDate" => Date("m.d.Y"),
            "Home" => "",
            "AdminHome" => ""
        ];
        $config = new Config($this->getPlugin()->getDataFolder() . "island_parameters/testIs.yml");
        foreach ($parameter as $key => $value) {
            $config->set($key, $value);
        }
        $config->save();

    }
}