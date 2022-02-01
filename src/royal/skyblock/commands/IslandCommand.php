<?php
namespace royal\skyblock\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use royal\skyblock\commands\subCommands\Create;
use royal\skyblock\commands\subCommands\Go;
use royal\skyblock\Main;

class IslandCommand extends BaseCommand{

    protected function prepare (): void
    {
        $this->registerSubCommand(new Create("create", Main::getInstance()->getLangageAPI()->getDafultTranslate("create_commands_description")));
        $this->registerSubCommand(new Go("go", Main::getInstance()->getLangageAPI()->getDafultTranslate("create_commands_description")));
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}