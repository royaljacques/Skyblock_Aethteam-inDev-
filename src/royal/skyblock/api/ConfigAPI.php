<?php

namespace royal\skyblock\api;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\skyblock\Main;

class ConfigAPI
{
    private Main $plugin;
    private Config $config;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
        $this->config = new Config($this->getPlugin()->getDataFolder() . "config.yml");
    }

    /**
     * @return Main
     */
    public function getPlugin (): Main
    {
        return $this->plugin;
    }

    /**
     * @return Config
     */
    public function getConfig (): Config
    {
        return $this->config;
    }

    public function registerIslandsList ()
    {
        $config = $this->getConfig()->getAll();
        foreach ($config['is'] as $is => $value) {
            $this->plugin->getServer()->getLogger()->info("§2island => " . $value['name'] . " <= has been registed");
            $this->plugin->islandList[$value['name']] = $value['folderName'];
        }
    }

    public function registerNewPlayer (Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        $config->set("hasIsland", false);
        $config->set("islandName", null);
        $config->set("rank", null);
        try {
            $config->save();
        } catch (\JsonException $jsonException) {
            echo $jsonException->getMessage();
        }
    }

    public function getHasIsland (Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get("hasIsland");
    }
    public function getIsland (Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get("islandName");
    }



    public function setownerIsland (Player $player, string $islandName)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        $config->set("hasIsland", true);
        $config->set("islandName", $islandName);
        $config->set("rank", "leader");
        try {
            $config->save();
        } catch (\JsonException $jsonException) {
            $this->getPlugin()->getLogger()->debug($jsonException->getMessage());
        }

    }

    public function setIslandConfig (string $compositCustomNameIs)
    {
        $IsleParam = new Config($this->getPlugin()->getDataFolder() . "isConfig/" . $compositCustomNameIs . '.yml', Config::YAML, array(
            "IsLevel" => 0,
            "IsXp" => 0,
            "home1" => null,
            "home2" => null,
            "home3" => null
        ));
        try {
            $IsleParam->save();
        } catch (\JsonException $jsonException) {
            $this->getPlugin()->getLogger()->debug($jsonException->getMessage());
        }
    }
}