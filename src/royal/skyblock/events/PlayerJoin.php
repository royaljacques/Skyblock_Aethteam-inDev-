<?php
namespace royal\skyblock\events;

use FormAPI\elements\Button;
use FormAPI\window\SimpleWindowForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\skyblock\Main;

class PlayerJoin implements Listener
{
    private Main $plugin;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return Main
     */
    public function getPlugin (): Main
    {
        return $this->plugin;
    }

    public function onJoin (PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        if (!$player->hasPlayedBefore()) {
            $this->newPlayer($player);
        }
    }

    public function newPlayer (Player $player)
    {
        $this->plugin->langageAPI->selectLangage($player);
    }


}