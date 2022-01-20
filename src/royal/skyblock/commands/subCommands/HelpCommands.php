<?php
namespace royal\skyblock\commands\subCommands;
use CortexPE\Commando\BaseSubCommand;
use royal\skyblock\Main;
use pocketmine\command\CommandSender;
class HelpCommands extends BaseSubCommand {

    public function __construct ()
    {
        parent::__construct("help", Main::getLangageAPI()->getIntoFileLangageConfig("help_commands_descrition"));
    }

    protected function prepare (): void
     {
     }

     public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
     {
         $sender->sendMessage(Main::getLangageAPI()->getIntoFileLangageConfig("help_reply_message"));
     }
 }