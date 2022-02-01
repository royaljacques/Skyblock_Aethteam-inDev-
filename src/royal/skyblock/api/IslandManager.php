<?php
namespace royal\skyblock\api;

use pocketmine\nbt\LittleEndianNbtSerializer;
use pocketmine\nbt\TreeRoot;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Binary;
use pocketmine\utils\Config;
use pocketmine\world\format\io\data\BedrockWorldData;
use royal\skyblock\Main;
use SplFileInfo;
use Webmozart\PathUtil\Path;

class IslandManager{
    private Main $plugin;
    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return Main
     */
    public function getPlugin (): Main
    {
        return $this->plugin;
    }

    public function createNewIsland(Player $player, int $isName){
        if ($this->getPlugin()->configAPI->getHasIsland($player) === false){
            $Folder = $this->getPlugin()->islandList[$isName];
            $compositCustomNameIs = "is_".$player->getName()."_".$this->GenerateRandomNumber();
            $this->getPlugin()->configAPI->setownerIsland($player, $compositCustomNameIs);
            $this->getPlugin()->configAPI->setIslandConfig($compositCustomNameIs);
            self::copyWorld($Folder, $compositCustomNameIs);
            $player->sendMessage($this->getPlugin()->getLangageAPI()->getTranslate($player, "create_successfull_complete"));
        }else{
            $player->sendMessage($this->getPlugin()->getLangageAPI()->getTranslate($player, "create_error_player_has_island"));
        }
    }

    private function GenerateRandomNumber(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    private static function copyWorld(string $from, string $name ): string{
        $server = Server::getInstance();
        @mkdir($server->getDataPath() . "/worlds/$name/");
        @mkdir($server->getDataPath() . "/worlds/$name/db/");

        copy(Main::getInstance()->getDataFolder() . "mapList/" . $from. "/level.dat", $server->getDataPath() . "/worlds/$name/level.dat");
        $oldWorldPath = Main::getInstance()->getDataFolder() . "/mapList/$from/level.dat";
        $newWorldPath = $server->getDataPath() . "/worlds/$name/level.dat";

        $oldWorldNbt = new BedrockWorldData($oldWorldPath);
        $newWorldNbt = new BedrockWorldData($newWorldPath);

        $worldData = $oldWorldNbt->getCompoundTag();
        $newWorldNbt->getCompoundTag()->setString("LevelName", $name);

        $nbt = new LittleEndianNbtSerializer();
        $buffer = $nbt->write(new TreeRoot($worldData));
        file_put_contents(Path::join($newWorldPath), Binary::writeLInt(BedrockWorldData::CURRENT_STORAGE_VERSION) . Binary::writeLInt(strlen($buffer)) . $buffer);
        self::copyDir(Main::getInstance()->getDataFolder() . "/mapList/" . $from . "/db", $server->getDataPath() . "/worlds/$name/db/");

        return $name;
    }

    private static function copyDir($from, $to){
        $to = rtrim($to, "\\/") . "/";
        /** @var SplFileInfo $file */
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($from)) as $file){
            if($file->isFile()){
                $target = $to . ltrim(substr($file->getRealPath(), strlen($from)), "\\/");
                $dir = dirname($target);
                if(!is_dir($dir)){
                    mkdir(dirname($target), 0777, true);
                }
                copy($file->getRealPath(), $target);
            }
        }
    }
}