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
        $form->addButton($this->plugin->getLangageAPI()->getTranslate($player, "skyblock_button_form"));
        $player->sendForm($form);
    }
    private function getMembersislands(Player $player){
        $form = new SimpleForm(function (Player $player, int $mdata = null){
            return true;
        });
        $memeberList = Main::getInstance()->configAPI->getMemberisland($player);
        $connectionType = "§4not Online";
        foreach ($memeberList as $memebers){
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $player){
                if ($memebers === $player->getName()){
                    $connectionType = "§2Online";
                }
                $form->addButton($memebers."\n".$connectionType, 0, "", $memebers);
            }
        }
        $player->sendForm($form);
    }
    private function selectOptions(Player $player, Player $target){
        $form = new SimpleForm(function (Player $player, int $data = null ){

        });
        $form->addButton($this->plugin->getLangageAPI()->getTranslate($player, "skyblock_button_ban"));
        $form->addButton($this->plugin->getLangageAPI()->getTranslate($player, "skyblock_button_promote"));
        $player->sendForm($form);
    }
    private function banMember(Player $player, Player $target){

    }
    private function promoteMemeber(Player $player, Player $target){

    }

    private function setPermissions(Player $player){

    }


}