<?php

namespace royal\skyblock\api;

use JsonException;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\world\generator\GeneratorUnregisterTask;
use royal\skyblock\Main;

class IslandParameterAPI
{
    private Main $plugin;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getPlugin (): Main
    {
        return $this->plugin;
    }

    public function getXpBlockConfig (): array
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml");
        return $config->get('block');
    }

    public function geIsMemberInIsland ($name, $islandName, string $type): bool
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "players/" . $name . '.yml');
        if ($config->get("island") === $islandName) {
            if ($config->get('isrank') === $type) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function MemberIsLeader(string $name): bool
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "players/" . $name . '.yml');
        if ($config->get('isrank') === "LEADER") {
            return false;
        }
        return true;
    }


}