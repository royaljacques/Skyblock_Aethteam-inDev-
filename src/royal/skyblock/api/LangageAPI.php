<?php

namespace royal\skyblock\api;

use pocketmine\utils\Config;
use royal\skyblock\Main;

class LangageAPI
{
    public Main $plugin;
    public array $langList = array();

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getLangage ()
    {
        $config = new Config($this->plugin->getDataFolder() . 'config.yml');
        return $config->get('langage');
    }

    public function loadLangConfig ()
    {
        $langFile = new Config($this->plugin->getDataFolder() . 'langages/' . $this->getLangage() . ".yml");
        foreach ($langFile->getAll() as $link => $stringDescription) {
            $this->langList[$link] = $stringDescription;
        }
    }

    public function getIntoFileLangageConfig (string $ymlText): string
    {
        return $this->langList[$ymlText];
    }
}