<?php
namespace royal\skyblock\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use royal\skyblock\commands\subCommands\Create;
use royal\skyblock\commands\subCommands\HelpCommands;
use royal\skyblock\commands\subCommands\SetAdminHome;

class RegisterCommands extends BaseCommand{

    protected function prepare (): void
    {
        $this->registerSubCommand(new HelpCommands());
        $this->registerSubCommand(new SetAdminHome());
        $this->registerSubCommand(new Create());
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}