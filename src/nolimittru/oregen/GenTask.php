<?php

namespace nolimittru\oregen;

use pocketmine\scheduler\Task;
class GenTask extends Task
{
    /** @var Main */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick): void
    {
        if (count($this->plugin->oreManager()->getBrokenOres()) > 0) {
            $this->plugin->oreManager()->replaceBlock();
        }
    }
}