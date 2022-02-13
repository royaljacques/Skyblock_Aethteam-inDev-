<?php
namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class ListCommands extends BaseSubCommand{

    protected function prepare(): void
    {
        // TODO: Implement prepare() method.
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {

        if ($sender instanceof Player)Main::getInstance()->configAPI->getIslandList($sender);
    }
}