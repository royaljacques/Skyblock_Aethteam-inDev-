<?php
namespace royal\skyblock\events;

use FormAPI\elements\Button;
use FormAPI\window\SimpleWindowForm;
use JsonException;
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
        if (!file_exists($this->plugin->getDataFolder()."players/".$player->getName().".yml")){
            $this->newPlayer($player);
        }
    }

    public function newPlayer (Player $player)
    {
        $this->getPlugin()->langageAPI->selectLangage($player);
        try {
            $this->getPlugin()->configAPI->registerNewPlayer($player);
        }catch (JsonException $jsonException){
            $this->getPlugin()->getServer()->getLogger()->alert($jsonException->getMessage());
        }
    }


}