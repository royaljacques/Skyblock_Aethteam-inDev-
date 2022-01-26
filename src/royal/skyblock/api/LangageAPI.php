<?php

namespace royal\skyblock\api;

use FormAPI\elements\Button;
use FormAPI\window\SimpleWindowForm;
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
        $form = new SimpleWindowForm("skyblock_form", "skyblock_lang", "Choice your langage", function (Player $player, Button $selected) {
            $config = new Config($this->plugin->getDataFolder() . "players/" . $player->getName() . ".yml");

            $config->set("lang", $selected->getText());
        });
        foreach ($this->translate as $key => $value) {
            $form->addButton($key, $key);
        }
        $player->sendForm($form);
    }

    /**
     * @param Player $player
     * @return string renvoie la langue du joueur
     *
     */
    public function getPlayerLangage (Player $player): string
    {
        $config = new Config($this->plugin->getDataFolder() . "players/" . $player->getName() . ".yml");
        return $config->get('lang');
    }

    /**
     * @param string $playerlangage use getPlayerLangage
     * @param string $langs
     * @return array
     */
    public function getTranslate (string $playerlangage, string $langs): array
    {
        return $this->translate[$playerlangage][$langs];
    }
}