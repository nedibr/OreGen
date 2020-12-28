<?php

namespace nolimittru\oregen;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    /** @var OreManager */
    private OreManager $oreManager;
    /** @var Config */
    public Config $config;

    public function onEnable(): void
    {
        $this->saveResource("config.json");
        $this->registerClasses();
        $this->getScheduler()->scheduleRepeatingTask(new GenTask($this), 160);
    }

    public function registerClasses(): void{
        $this->config = new Config($this->getDataFolder() . "config.json", Config::JSON);
        $this->oreManager = new OreManager($this, $this->config->get("arenas"));
        $this->getServer()->getPluginManager()->registerEvents(new GenListener($this), $this);
    }

    public function oreManager(): OreManager
    {
        return $this->oreManager;

    }

}
