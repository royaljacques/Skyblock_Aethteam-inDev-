<?php
namespace royal\skyblock\commands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use royal\skyblock\commands\subCommands\HelpCommands;
use royal\skyblock\Main;

class RegisterCommands extends BaseCommand{

    protected function prepare (): void
    {

        $this->registerSubCommand(new HelpCommands());
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}