<?php

namespace nolimittru\oregen;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;

use function in_array;

class GenListener implements Listener
{
    /** @var Main */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function handleBlockBreak(BlockBreakEvent $event): void
    {
        $blocks = OreManager::ORES;
        $block = $event->getBlock();
        if ($this->plugin->oreManager()->checkOreLevel($block->getLevel()->getName())) {
            if (in_array($block->getItemId(), $blocks)) {
                $this->plugin->oreManager()->addOre($block->asPosition());
            }
        }
    }
}
