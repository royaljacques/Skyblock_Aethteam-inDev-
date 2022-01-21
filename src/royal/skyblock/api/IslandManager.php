<?php
namespace royal\skyblock\api;

use pocketmine\nbt\LittleEndianNbtSerializer;
use pocketmine\nbt\TreeRoot;
use pocketmine\Server;
use pocketmine\utils\Binary;
use pocketmine\utils\Config;
use pocketmine\world\format\io\data\BedrockWorldData;
use royal\skyblock\Main;
use Webmozart\PathUtil\Path;

class IslandManager{

    private Main $plugin;


    public function __construct (Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getPlugin(): Main
    {
        return $this->plugin;
    }
    public function init(){

    }
    public static function copyWorld(string $from, string $name ): string{
        $server = Server::getInstance();
        @mkdir($server->getDataPath() . "/worlds/$name/");
        @mkdir($server->getDataPath() . "/worlds/$name/db/");

        copy(Main::getInstance()->getDataFolder() . "/mapList/" . $from. "/level.dat", $server->getDataPath() . "/worlds/$name/level.dat");
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

    public static function copyDir($from, $to){
        $to = rtrim($to, "\\/") . "/";
        /** @var \SplFileInfo $file */
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
    public function CreateIsland(string $id, string $name){
        $config = new Config($this->getPlugin()->getDataFolder()."mapList/mapList.yml");
        $selector = $config->get(1);
        $compositCustomNameIs = "is_".$name."_".$this->GenerateRandomNumber();
        self::copyWorld($selector['name'], $compositCustomNameIs);

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


}