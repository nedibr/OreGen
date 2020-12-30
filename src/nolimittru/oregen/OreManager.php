<?php

namespace nolimittru\oregen;

use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

use function in_array;
use function explode;
use function array_shift;

class OreManager
{
    public const ORES = [
        BlockIds::GOLD_ORE, BlockIds::DIAMOND_ORE,
        BlockIds::COAL_ORE, BlockIds::IRON_ORE,
        BlockIds::REDSTONE_ORE, BlockIds::EMERALD_ORE,
        BlockIds::NETHER_QUARTZ_ORE, BlockIds::LAPIS_ORE
    ];

    /** @var Main */
    private Main $plugin;
    /** @var array */
    private array $arenas;
    /** @var array */
    private array $brokenOres = [];

    public function __construct(Main $plugin, array $arenas)
    {
        $this->plugin = $plugin;
        $this->arenas = $arenas;

        foreach ($this->arenas as $arena) {
            if (!$this->plugin->getServer()->isLevelLoaded($arena)) {
                $this->plugin->getServer()->loadLevel($arena);
            }
        }
    }

    public function replaceBlock(): void
    {
        $block = explode(":", $this->brokenOres[0]);
        $this->plugin->getServer()
            ->getLevel($block[3])
            ->setBlock(new Vector3($block[0], $block[1], $block[2]),
                Block::get(self::ORES[array_rand(self::ORES)], 0));
        array_shift($this->brokenOres);
    }

    public function addOre(Position $pos): void
    {
        $format = "{$pos->getX()}:{$pos->getY()}:{$pos->getZ()}:{$pos->getLevel()->getId()}";
        $this->brokenOres[] = $format;
        $this->plugin->getServer()->getLevel($pos->getLevel()
            ->getId())
            ->setBlock($pos, Block::get(BlockIds::BEDROCK));
    }

    public function checkOreLevel(string $levelName): bool
    {
        return in_array($levelName, $this->arenas, true);
    }

    public function getLoadedArenas(): array
    {
        return $this->arenas;
    }

    public function getBrokenOres(): array
    {
        return $this->brokenOres;
    }

}
