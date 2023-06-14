<?php

namespace Corentin503JQDL;

use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    private Webhook $webhook;

    protected function onEnable(): void
    {
        $this->saveDefaultConfig();

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        if ($this->getConfig()->get("webhook") == "") $this->getLogger()->alert("Please enter url in config.yml for webhook");

        $this->webhook = new Webhook($this->getConfig()->get("webhook"));
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $message = new Message();
        $message->setContent(str_replace("{player}", $event->getPlayer()->getName(), $this->getConfig()->get("join")));
        $this->webhook->send($message);
    }

    public function onQuit(PlayerQuitEvent $event)
    {
        $message = new Message();
        $message->setContent(str_replace("{player}", $event->getPlayer()->getName(), $this->getConfig()->get("quit")));
        $this->webhook->send($message);
    }
}