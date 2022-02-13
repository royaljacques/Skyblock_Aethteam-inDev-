<?php
namespace royal\skyblock\api;

use pocketmine\player\Player;
use royal\skyblock\Main;
use Vecnavium\FormsUI\SimpleForm;

class GestionAPI{
    public Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }
    public function indexForm(Player $player){
        $form = new SimpleForm(function (Player $player, int $meta = null){
            if ($meta === null){
                return true;
            }
            switch ($meta){
                case 0:
                    $this->getMembersislands($player);
                    break;
            }
            return true;
        });
        $form->setTitle($this->plugin->getLangageAPI()->getTranslate($player, "skyblock_title_form"));
        $form->setContent($this->plugin->getLangageAPI()->getTranslate($player, "skyblock_content_form"));

    }

    private function getMembersislands(Player $player){

    }
    private function banMember(Player $player){

    }

    private function setPermissions(Player $player){

    }


}