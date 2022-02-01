<?php
namespace royal\skyblock\commands\subCommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\EffectManager;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\player\Player;
use royal\skyblock\Main;

class Create extends  BaseSubCommand{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare (): void
    {
        //foreach (Main::getInstance()->islandList as $is){}

        $this->registerArgument(0, new RawStringArgument("salut", true));
        $this->registerArgument(1, new RawStringArgument("t(est1", true));
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        var_dump($args);
        if (!isset($args)){
            if ($sender instanceof Player)$sender->sendMessage(Main::getInstance()->getLangageAPI()->getTranslate($sender, "create_error_player_has_island"));
        }
    }
}