<?php

namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawMessageArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\EffectManager;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Create extends BaseSubCommand
{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare (): void
    {
        $this->registerArgument(0, new RawStringArgument("Island Name"));
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args)) {
            if ($sender instanceof Player) $sender->sendMessage(Main::getInstance()->getLangageAPI()->getTranslate($sender, "create_error_player_has_island"));
        }
        if (array_key_exists($args['Island Name'], Main::getInstance()->islandList)){
            Main::getInstance()->getIslandManager()->createNewIsland($sender, $args['Island Name']);

        }else{
            $sender->sendMessage(Main::getInstance()->getLangageAPI()->getTranslate($sender, "create_error_island_not_exist"));
        }
    }
}