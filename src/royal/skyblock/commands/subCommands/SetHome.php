<?php
namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\BlockPositionArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class SetHome extends BaseSubCommand{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home_name"));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player){
            Main::$instance->configAPI->setHome($sender, $args['home_name']);
        }
    }
}