<?php

namespace royal\skyblock;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use royal\skyblock\api\LangageAPI;
use royal\skyblock\api\LoaderAPI;
use royal\skyblock\events\PlayerJoin;

class Main extends PluginBase implements Listener
{
    private LoaderAPI $loaderAPI;
    public LangageAPI $langageAPI;

    protected function onLoad (): void
    {
        $this->loaderAPI = new LoaderAPI($this);
    }

    protected function onEnable (): void
    {
        $this->loaderAPI->init();
        $config = new Config($this->getDataFolder() . "config.yml");
        $this->langageAPI = new LangageAPI($this);
        $this->langageAPI->init();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoin($this), $this);
    }


}