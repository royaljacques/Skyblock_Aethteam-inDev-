<?php

namespace royal\skyblock\api;

use JsonException;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use royal\skyblock\Main;

class ConfigAPI
{
    private Main $plugin;
    private Config $config;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $this->config = new Config($this->getPlugin()->getDataFolder() . "config.yml");
    }

    /**
     * @return Main
     */
    public function getPlugin(): Main
    {
        return $this->plugin;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function registerIslandsList()
    {
        $config = $this->getConfig()->getAll();
        foreach ($config['is'] as $is => $value) {
            $this->plugin->getServer()->getLogger()->info("§2island => " . $value['name'] . " <= has been registed");
            $this->plugin->islandList[$value['name']] = $value['folderName'];
        }
    }

    public function registerNewPlayer(Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        $config->set("hasIsland", false);
        $config->set("islandName", null);
        $config->set("rank", null);
        try {
            $config->save();
        } catch (JsonException $jsonException) {
            echo $jsonException->getMessage();
        }
    }

    public function getHasIsland(Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get("hasIsland");
    }

    public function getIsland(Player $player)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get("islandName");
    }


    public function setownerIsland(Player $player, string $islandName)
    {
        $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        $config->set("hasIsland", true);
        $config->set("islandName", $islandName);
        $config->set("rank", "leader");
        try {
            $config->save();
        } catch (JsonException $jsonException) {
            $this->getPlugin()->getLogger()->debug($jsonException->getMessage());
        }
    }

    public function setIslandConfig(string $compositCustomNameIs)
    {
        $IsleParam = new Config($this->getPlugin()->getDataFolder() . "isConfig/" . $compositCustomNameIs . '.yml', Config::YAML, array(
            "IsLevel" => 0,
            "IsXp" => 0,
            "homes" => [

            ]
        ));
        try {
            $IsleParam->save();
        } catch (JsonException $jsonException) {
            $this->getPlugin()->getLogger()->debug($jsonException->getMessage());
        }
    }

    private function getIslandCOnfig(string $islandName): Config
    {
        return new Config($this->getPlugin()->getDataFolder() . "isConfig/" . $islandName . '.yml', Config::YAML);
    }

    /**
     * @throws JsonException
     */
    public function setHome(Player $player, $homename)
    {
        if ($this->getHasIsland($player) === true) {
            $playerconfig = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
            if ($playerconfig->get("rank") === strtolower("leader")) {
                $islandName = $this->getIsland($player);
                $config = $this->getIslandCOnfig($islandName);
                $homes = $config->get("homes");
                if (count($homes) < $this->getConfig()->get("islandLevelConfig")[$this->getIslandCOnfig($islandName)->get("IsLevel")]["home_max"]) {
                    $x = $player->getPosition()->getX();
                    $y= $player->getPosition()->getY();
                    $z = $player->getPosition()->getZ();
                    $world_name = $player->getPosition()->getWorld()->getDisplayName();
                    $position = $x.":".$y.":".$z;
                    $config->set("homes", array_merge($homes, [$homename => ["position"=>$position, "world"=>$world_name]]));
                    $config->save();
                    $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "sethome_succes"));
                } else {
                    $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "sethome_max_home_reached"));
                }
            } else {
                $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "sethome_no_permission"));
            }
        }
    }
    public function Home(Player $player, $homeName){
        $playerconfig = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        $islandName = $this->getIsland($player);
        $config = $this->getIslandCOnfig($islandName);
        $homes = $config->get("homes");
        if (count($homes) === 0){
            $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "home_no_existed_home"));
        }else{
            foreach ($homes as $home){
                if ($home === $homeName){
                    $this->teleportToHome($player, $home);
                }
            }
        }
    }
    private function teleportToHome(Player $player, array $home){
        $position = explode(":", $home['position']);
        $levelName = $home['world'];
        $player->teleport(new Position($position[0], $position[1], $position[2], $levelName));
        $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "home_tp_success"));
    }
}