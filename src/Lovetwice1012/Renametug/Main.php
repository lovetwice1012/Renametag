<?php

namespace Lovetwice1012\Renametug;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;

class Main extends PluginBase implements Listener{

	private $fly;

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $event){
		$this->fly[$event->getPlayer()->getName()] = false;
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($label === "atama") {
            if ($sender->isOp()) {
                $player = $this->getServer()->getPlayer($args[0]);
                $tag = $args[1];
                $player->setNameTag("[§d$tag]".$player->getName());
                $player->setDisplayName("[§d$tag]".$player->getName());
		$sender->sendMessage("頭の上の名前表示が"."[§d$tag]".$player->getName()."になりました");
            }else{
	        $sender->sendMessage("§c権限がありません");
        }
        return true;
    }

}
