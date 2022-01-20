<?php

namespace royal\skyblock;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use royal\skyblock\api\LangageAPI;
use royal\skyblock\commands\RegisterCommands;

class Main extends PluginBase implements Listener
{
    public static self $instance;

    public static LangageAPI $langageAPI;

    protected function onLoad (): void
    {
        self::$langageAPI = new LangageAPI($this);
        self::$instance = $this;
    }

    /**
     * @throws HookAlreadyRegistered
     */
    protected function onEnable (): void
    {
        if (file_exists($this->getDataFolder() . 'langages/' . Main::getLangageAPI()->getLangage() . ".yml")) {
            $this->registerConfigs($this->getResources());
            self::getLangageAPI()->loadLangConfig();

            if (!PacketHooker::isRegistered()) {
                PacketHooker::register($this);
            }
            $this->getServer()->getCommandMap()->register("", new RegisterCommands($this, "is", self::getLangageAPI()->getIntoFileLangageConfig("is_commands_descrition")));
        } else {
            $this->registerConfigs($this->getResources());
            Main::getInstance()->getServer()->getPluginManager()->disablePlugin(Main::getInstance()->getServer()->getPluginManager()->getPlugin('Skyblock_Aethteam'));
        }
    }

    public function registerConfigs ($path)
    {
        foreach ($path as $pats => $p) {
            $this->saveResource($pats, true);
        }
    }

    public static function getInstance (): Main
    {
        return self::$instance;
    }

    public static function getLangageAPI (): LangageAPI
    {
        return self::$langageAPI;
    }
}