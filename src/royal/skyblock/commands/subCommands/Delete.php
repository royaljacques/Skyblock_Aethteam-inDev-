<?php
namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Delete extends BaseSubCommand{

    protected function prepare(): void
    {

    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player){
            Main::getInstance()->configAPI->deleteIsland($sender);
        }
    }
}