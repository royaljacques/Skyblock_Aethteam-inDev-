<?php

namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use royal\skyblock\api\IslandManager;
use royal\skyblock\Main;

class Create extends BaseSubCommand{

    public function __construct ()
    {
        parent::__construct("create", Main::getLangageAPI()->getIntoFileLangageConfig("create_commands_description"));
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare (): void
    {
        $this->registerArgument(0, new IntegerArgument("id_map"));
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        $l = new IslandManager(Main::getInstance());
        $l->CreateIsland($args["id_map"], $sender->getName());
        $sender->sendMessage(Main::getLangageAPI()->getIntoFileLangageConfig("create_successfull_complete"));
    }
}