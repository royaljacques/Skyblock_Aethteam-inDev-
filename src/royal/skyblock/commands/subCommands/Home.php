<?php
namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Home extends BaseSubCommand{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home_name"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player){
            if (!(Main::getInstance()->getServer()->getWorldManager()->loadWorld(Main::getInstance()->configAPI->getIsland($sender)))) {
                return;
            }
            Main::getInstance()->configAPI->Home($sender, $args['home_name']);
        }
    }
}