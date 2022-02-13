<?php

namespace royal\skyblock\api;

use JsonException;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use royal\skyblock\Main;

class ConfigAPI
{
    private Main $plugin;
    private Config $config;
    private array $isLevelConfig = [];

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
     * @return array
     */
    public function getIsLevelConfig(): array
    {
        return $this->isLevelConfig;
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
        foreach ($config['islandLevelConfig'] as $level => $stats) {
            $this->isLevelConfig[$level] = $stats;
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
            $this->plugin->getLogger()->alert($jsonException->getMessage());
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

            ],
            "permissions" => [
                "co-leader-invite" => false,
                "co-leader-interact-chest" => false,
                "co-leader-sethome-commands" => false,
            ],
            "members" =>[

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
            $islandName = $this->getIsland($player);
            $config = $this->getIslandCOnfig($islandName);
            if ($playerconfig->get("rank") === strtolower("leader") || ($playerconfig->get("rank") === strtolower("leader") && $config->getNested('permissions.co-leader-sethome-commands') === true)) {


                $homes = $config->get("homes");
                if (count($homes) <= $this->getConfig()->get("islandLevelConfig")[$this->getIslandCOnfig($islandName)->get("IsLevel")]["home_max"]) {
                    $x = $player->getPosition()->getX();
                    $y = $player->getPosition()->getY();
                    $z = $player->getPosition()->getZ();
                    $world_name = $player->getPosition()->getWorld()->getDisplayName();
                    $position = $x . ":" . $y . ":" . $z;
                    $config->set("homes", array_merge($homes, [$homename => ["position" => $position, "world" => $world_name]]));
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

    public function Home(Player $player, $homeName)
    {
        $islandName = $this->getIsland($player);
        $config = $this->getIslandCOnfig($islandName);
        $homes = $config->get("homes");
        if (count($homes) === 0) {
            $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "home_no_existed_home"));
        } else {
            foreach ($homes as $home => $homess) {
                if ($home === $homeName) {
                    $this->teleportToHome($player, $homess);
                    return;
                }
            }
        }
    }

    private function teleportToHome(Player $player, array $home)
    {
        $position = explode(":", $home['position']);
        $levelName = $home['world'];
        $player->teleport(new Position(intval($position[0]), intval($position[1]), intval($position[2]), Server::getInstance()->getWorldManager()->getWorldByName($levelName)));
        $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "home_tp_success"));
    }

    /**
     * @throws JsonException
     */
    public function deleteHome(Player $player, $homeName){
        $NameIs = $this->getIsland($player);
        $config = $this->getIslandCOnfig($NameIs);
        $homes = $config->get("homes");
        if (count($homes) === 0) {
            $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "home_no_existed_home"));
        } else {
            foreach ($homes as $home => $homess) {
                if ($home === $homeName) {
                    unset($homes[$homeName]);
                    var_dump($homes);
                    $config->set('homes', $homes);
                    $config->save();
                    $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "delhome_successful_delete"));
                }
            }

        }
    }

    public function deleteIsland(Player $player){
        $playerconfig = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
        if ($playerconfig->get("rank") === strtolower("leader")) {
            $islandName = $this->getIsland($player);
            $this->getPlugin()->getIslandManager()->MooveIsland($islandName);
            unlink($this->getPlugin()->getDataFolder()."isConfig/" . $this->getIsland($player) . '.yml');
            $config = new Config($this->getPlugin()->getDataFolder() . "players/" . $player->getName() . ".yml");
            $config->set("islandName", null);
            $config->set("hasIsland", false);
            $config->save();
            $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "delete_succes"));
        }
    }

    public function getIslandList(Player $player){
        $player->sendMessage($this->plugin->getLangageAPI()->getTranslate($player, "list_reply_message"));
        foreach ($this->plugin->islandList as $islandName => $values){
            $player->sendMessage($islandName);
        }
    }

    /**
     * @throws JsonException
     */
    public function addPlayerIsland(Player $player){
        $member = $this->getIslandCOnfig($player)->get("members");
        $member[] = $player->getName();
        $this->config->set("members", $member);
        $this->config->save();
    }
    public function getMemberisland(Player $player){
        return $this->config->get("members");
    }
}