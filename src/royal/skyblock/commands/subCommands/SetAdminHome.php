<?php
namespace royal\skyblock\commands\subCommands;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\Main;

class SetAdminHome extends BaseSubCommand{


    public function __construct ()
    {
        parent::__construct("setadminhome", Main::getLangageAPI()->getIntoFileLangageConfig("setadminhome_commands_description"));
    }
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare (): void
    {
        $this->registerArgument(0, new RawStringArgument("name"));
    }

    public function onRun (CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player){
            $pos = $sender->getPosition();
            var_dump($pos);
        }
    }
}