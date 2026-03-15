<?php

declare(strict_types=1);

namespace RulesUI;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase{

    public function onEnable() : void{
        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{

        if($command->getName() === "rules"){

            if(!$sender instanceof Player){
                $sender->sendMessage("Use this command in-game.");
                return true;
            }

            $sender->sendMessage($this->color($this->getConfig()->getNested("messages.open")));
            $this->openRules($sender);
        }

        return true;
    }

    private function openRules(Player $player) : void{

        $form = new SimpleForm(function(Player $player, $data){
            if($data === null){
                return;
            }

            $player->sendMessage($this->color($this->getConfig()->getNested("messages.close")));
        });

        $form->setTitle($this->color($this->getConfig()->getNested("form.title")));
        $form->setContent($this->color($this->getConfig()->getNested("form.content")));
        $form->addButton($this->color($this->getConfig()->getNested("form.close-button")));

        $player->sendForm($form);
    }

    private function color(string $text) : string{
        return str_replace("&", "§", $text);
    }
}
