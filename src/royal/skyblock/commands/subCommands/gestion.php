<?php
namespace royal\skyblock\commands\subCommands;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\skyblock\api\GestionAPI;
use royal\skyblock\Main;

class gestion extends BaseSubCommand{

    protected function prepare(): void
    {
        // TODO: Implement prepare() method.
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $gestion = new GestionAPI(Main::getInstance());
        if ($sender instanceof Player)$gestion->indexForm($sender);
    }
}