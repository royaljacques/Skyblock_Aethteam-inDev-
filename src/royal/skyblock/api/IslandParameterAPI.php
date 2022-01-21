<?php

namespace royal\skyblock\api;

use JsonException;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\Config;
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


}