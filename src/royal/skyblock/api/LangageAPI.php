<?php

namespace royal\skyblock\api;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use raklib\protocol\NACK;
use royal\skyblock\Main;

class LangageAPI
{
    private Main $plugin;

    private array $translate;

    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function init ()
    {
        $this->loadLangage();
    }

    private function loadLangage ()
    {

        $dir = opendir($this->plugin->getDataFolder() . "langs");
        while ($dirs = readdir($dir)) {
            if ($dirs != "." && $dirs != "..") {
                if (!is_dir($dirs)) {
                    $config = new Config($this->plugin->getDataFolder() . "langs/" . $dirs);
                    foreach ($config->getAll() as $key => $value) {
                        $this->translate[explode(".", $dirs)[0]][$key] = $value;
                    }
                }
            }
        }
    }

    private function reloadLangage ()
    {
        $this->translate = [];
        $dir = opendir($this->plugin->getDataFolder() . "langs");
        while ($dirs = readdir($dir)) {
            if ($dirs != "." && $dirs != "..") {
                if (!is_dir($dirs)) {
                    $config = new Config($this->plugin->getDataFolder() . "langs/" . $dirs);
                    foreach ($config->getAll() as $key => $value) {
                        $this->translate[explode(".", $dirs)[0]][$key] = $value;
                    }
                }
            }
        }
    }

    public function selectLangage (Player $player)
    {
        $form = new SimpleForm(function (Player $player, $selected = null) {
            if ($selected === null){
                $this->selectLangage($player);
            }
            $config = new Config($this->plugin->getDataFolder() . "players/" . $player->getName() . ".yml");
            $config->set("lang", $selected);
            $config->save();
        });
        foreach ($this->translate as $key => $value) {
            $form->addButton($key, 0, "", $key);
        }
        $player->sendForm($form);
    }

    /**
     * @param Player $player
     * @return string renvoie la langue du joueur
     *
     */
    private function getPlayerLangage (Player $player): string
    {
        $config = new Config($this->plugin->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get('lang');
    }

    /**
     * @param Player $player
     * @param string $langs
     * @return string
     */
    public function getTranslate (Player $player, string $langs): string
    {
        return $this->translate[$this->getPlayerLangage($player)][$langs];
    }

    /**
     * @param string $langs
     * @return string
     */
    public function getDafultTranslate (string $langs):string    {
        return $this->translate[$this->getPrincipalLangage()][$langs];
    }

    public function getPrincipalLangage(){
        $config = new Config($this->plugin->getDataFolder() . "config.yml");
        return $config->get("serverlang");
    }
}
