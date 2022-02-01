<?php

namespace royal\skyblock\commands\subCommands;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Go extends \CortexPE\Commando\BaseSubCommand
{

    /**
     * @inheritDoc
     */
    protected function prepare (): void
    {

    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            if (Main::getInstance()->configAPI->getHasIsland($sender) === true){
                if (!(Main::getInstance()->getServer()->getWorldManager()->loadWorld(Main::getInstance()->configAPI->getIsland($sender)))) {
                    return;
                }
                $targetSpawn = Main::getInstance()->getServer()->getWorldManager()->getWorldByName(Main::getInstance()->configAPI->getIsland($sender));

                $sender->teleport($targetSpawn->getSafeSpawn());
            }else{
                $sender->sendMessage(Main::getInstance()->getLangageAPI()->getTranslate($sender, "go_no_island"));
            }
        }
    }
}