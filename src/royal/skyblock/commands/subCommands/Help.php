<?php

namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Help extends BaseSubCommand{

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player){
            $sender->sendMessage(Main::getInstance()->getLangageAPI()->getTranslate($sender, "help_reply_message"));
        }
    }

    protected function prepare(): void
    {
        // TODO: Implement prepare() method.
    }
}
