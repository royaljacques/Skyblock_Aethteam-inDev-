<?php
namespace royal\skyblock\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use royal\skyblock\commands\subCommands\Create;
use royal\skyblock\commands\subCommands\Delete;
use royal\skyblock\commands\subCommands\DelHome;
use royal\skyblock\commands\subCommands\Go;
use royal\skyblock\commands\subCommands\Home;
use royal\skyblock\commands\subCommands\ListCommands;
use royal\skyblock\commands\subCommands\SetHome;
use royal\skyblock\commands\subCommands\Help;
use royal\skyblock\Main;

class IslandCommand extends BaseCommand{

    protected function prepare (): void
    {
        $this->registerSubCommand(new Create("create", Main::getInstance()->getLangageAPI()->getDafultTranslate("create_commands_description")));
        $this->registerSubCommand(new Go("go", Main::getInstance()->getLangageAPI()->getDafultTranslate("go_commands_description")));
        $this->registerSubCommand(new SetHome("sethome", Main::getInstance()->getLangageAPI()->getDafultTranslate("sethome_commands_description")));
        $this->registerSubCommand(new Home("home", Main::getInstance()->getLangageAPI()->getDafultTranslate("home_commands_description")));

        $this->registerSubCommand(new DelHome("delhome", Main::getInstance()->getLangageAPI()->getDafultTranslate("delhome_commands_description")));
        $this->registerSubCommand(new Delete("delete", Main::getInstance()->getLangageAPI()->getDafultTranslate("delete_commands_description")));
        $this->registerSubCommand(new Help("help", Main::getInstance()->getLangageAPI()->getDafultTranslate("help_commands_descrition")));
        $this->registerSubCommand(new ListCommands("list", Main::getInstance()->getLangageAPI()->getDafultTranslate("help_commands_descrition")));

    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}
