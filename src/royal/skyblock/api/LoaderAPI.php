<?php

namespace royal\skyblock\api;

use royal\skyblock\Main;

class LoaderAPI
{
    private Main $plugin;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function init ()
    {
        $this->registerConfigs();
    }

    private function registerConfigs ()
    {
        $this->plugin->saveResource('config.yml');
        @mkdir($this->plugin->getDataFolder() . "langs/");
        $this->plugin->saveResource("langs/fr_FR.yml");
        @mkdir($this->plugin->getDataFolder()."players/");
    }
}