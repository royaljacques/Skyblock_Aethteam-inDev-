<?php
namespace royal\skyblock\commands\subCommands;


use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;

class DelHome extends BaseSubCommand{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home_name"));

    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}