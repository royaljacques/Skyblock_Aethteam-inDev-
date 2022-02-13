<?php
namespace royal\skyblock\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use royal\skyblock\commands\subCommands\Create;
use royal\skyblock\commands\subCommands\Delete;
use royal\skyblock\commands\subCommands\DelHome;
use royal\skyblock\commands\subCommands\gestion;
use royal\skyblock\commands\subCommands\Go;
use royal\skyblock\commands\subCommands\Home;
use royal\skyblock\commands\subCommands\ListCommands;
use royal\skyblock\commands\subCommands\SetHome;
use royal\skyblock\commands\subCommands\Help;
use royal\skyblock\Main;

class IslandCommand extends BaseCommand{


    protected function prepare (): void
    {
        $this->registerSubCommand(new Create(Main::getInstance(), "create", Main::getInstance()->getLangageAPI()->getDafultTranslate("create_commands_description")));
        $this->registerSubCommand(new Go(Main::getInstance(),"go", Main::getInstance()->getLangageAPI()->getDafultTranslate("go_commands_description")));
        $this->registerSubCommand(new SetHome(Main::getInstance(),"sethome", Main::getInstance()->getLangageAPI()->getDafultTranslate("sethome_commands_description")));
        $this->registerSubCommand(new Home(Main::getInstance(),"home", Main::getInstance()->getLangageAPI()->getDafultTranslate("home_commands_description")));
        $this->registerSubCommand(new DelHome(Main::getInstance(),"delhome", Main::getInstance()->getLangageAPI()->getDafultTranslate("delhome_commands_description")));
        $this->registerSubCommand(new Delete(Main::getInstance(),"delete", Main::getInstance()->getLangageAPI()->getDafultTranslate("delete_commands_description")));
        $this->registerSubCommand(new Help(Main::getInstance(),"help", Main::getInstance()->getLangageAPI()->getDafultTranslate("help_commands_descrition")));
        $this->registerSubCommand(new ListCommands(Main::getInstance(),"list", Main::getInstance()->getLangageAPI()->getDafultTranslate("list_commands_descrition")));
        $this->registerSubCommand(new gestion(Main::getInstance(),"gestion", Main::getInstance()->getLangageAPI()->getDafultTranslate("gestion_commands_descrition")));

    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}
