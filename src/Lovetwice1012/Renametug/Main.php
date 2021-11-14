<?php

namespace Lovetwice1012\Renametug;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

	private $fly;
	public $myConfig;

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->myConfig = new Config($this->getDataFolder()."MyConfig.yml", Config::YAML);

	}

	public function onJoin(PlayerJoinEvent $event){
		$config = $this->myConfig;
		$player = $event->getPlayer();
		/** @var Config $config */
		if($config->exists($player->getName())){
			$player->setNameTag($config->get($player->getName()));
			$player->setDisplayName($config->get($player->getName()));
		}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		$config = $this->myConfig;
		if($label === "atama"){
			if($this->getServer()->isOp($sender->getName())){
				if(!isset($args[0])){
					$sender->sendMessage("§c使用方法:/atama 変更したい人の名前　変更後の名前");
					return true;
				}

				$name = $args[0];
				$player = $this->getServer()->getPlayer($name);
				if($player instanceof Player){
					$name = $player->getName();
				}

				if(isset($args[1])){
					$tag = $args[1];
					$nametag = "[§d".$tag."§r]".$name;
					//$displayName = "[§d".$tag."§r]".$name;
				}else{
					$nametag = $name;
					//$displayName = $name;
				}

				$config->set($name, $nametag);
				$config->save();
				$player->setNameTag($nametag);
				$player->setDisplayName($nametag);

				$sender->sendMessage("頭の上の名前表示が".$config->get($name)."になりました");
			}else{
				$sender->sendMessage("§c権限がありません");
			}

		}
		return true;
	}

}
