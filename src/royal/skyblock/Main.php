<?php

namespace royal\skyblock;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use royal\skyblock\api\ConfigAPI;
use royal\skyblock\api\IslandManager;
use royal\skyblock\api\LangageAPI;
use royal\skyblock\api\LoaderAPI;
use royal\skyblock\commands\IslandCommand;
use royal\skyblock\events\PlayerJoin;

class Main extends PluginBase implements Listener
{
    private LoaderAPI $loaderAPI;
    public LangageAPI $langageAPI;
    public array $islandList;
    public ConfigAPI $configAPI;
    public static Main $instance;
    public IslandManager $islandManager;

    /**
     * @return Main
     */
    public static function getInstance (): Main
    {
        return self::$instance;
    }

    /**
     * @return LangageAPI
     */
    public function getLangageAPI (): LangageAPI
    {
        return $this->langageAPI;
    }

    /**
     * @return array
     */
    public function getIslandList (): array
    {
        return $this->islandList;
    }

    /**
     * @return IslandManager
     */
    public function getIslandManager (): IslandManager
    {
        return $this->islandManager;
    }

    protected function onLoad (): void
    {
        $this->loaderAPI = new LoaderAPI($this);
        self::$instance = $this;
        $this->configAPI = new ConfigAPI($this);
        $this->langageAPI = new LangageAPI($this);
        $this->islandManager = new IslandManager($this);
    }

    protected function onEnable (): void
    {

        if (!PacketHooker::isRegistered()) {
            try {
                PacketHooker::register($this);
            } catch (HookAlreadyRegistered $e) {
                $this->getLogger()->alert($e->getMessage());
            }
        }
        $this->loaderAPI->init();
        $config = new Config($this->getDataFolder() . "config.yml");
        $this->langageAPI->init();
        $this->configAPI->registerIslandsList();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoin($this), $this);
        $this->getServer()->getCommandMap()->register("skyblock", new IslandCommand($this, "island", "", ["is"]));
    }
}