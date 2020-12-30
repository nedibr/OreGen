<?php

namespace nolimittru\oregen;

use pocketmine\scheduler\Task;
class GenTask extends Task
{
    /** @var Main */
    private Main $plugin;

    /** @var string */
    private string $block;

    public function __construct(Main $plugin, string $block)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick): void
    {
        $this->plugin->oreManager()->replaceBlock($this->block);
    }
}