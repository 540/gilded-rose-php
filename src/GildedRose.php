<?php

namespace GildedRose;

class GildedRose
{
    private const AGED_BRIE = 'Aged Brie';
    private const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';
    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    
    private const MAX_QUALITY = 50;
    private const MIN_QUALITY = 0;
    
    private const QUALITY_INCREASE = 1;
    private const QUALITY_DECREASE = 1;
    
    private const BACKSTAGE_FIRST_THRESHOLD = 11;
    private const BACKSTAGE_SECOND_THRESHOLD = 6;
    
    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItemQuality($item);
        }
    }

    private function updateItemQuality(Item $item): void
    {
        if ($this->isSulfuras($item)) {
            return;
        }

        $this->updateQualityBeforeSellIn($item);
        $this->decreaseSellIn($item);
        $this->updateQualityAfterSellIn($item);
    }

    private function updateQualityBeforeSellIn(Item $item): void
    {
        if ($this->isAgedBrie($item)) {
            $this->increaseQuality($item);
        } elseif ($this->isBackstagePass($item)) {
            $this->updateBackstagePassQuality($item);
        } else {
            $this->decreaseQuality($item);
        }
    }

    private function updateQualityAfterSellIn(Item $item): void
    {
        if ($item->sellIn >= 0) {
            return;
        }

        if ($this->isAgedBrie($item)) {
            $this->increaseQuality($item);
            return;
        }

        if ($this->isBackstagePass($item)) {
            $this->resetQuality($item);
            return;
        }

        $this->decreaseQuality($item);
    }

    private function updateBackstagePassQuality(Item $item): void
    {
        $this->increaseQuality($item);

        if ($item->sellIn < self::BACKSTAGE_FIRST_THRESHOLD) {
            $this->increaseQuality($item);
        }

        if ($item->sellIn < self::BACKSTAGE_SECOND_THRESHOLD) {
            $this->increaseQuality($item);
        }
    }

    private function increaseQuality(Item $item): void
    {
        if ($item->quality < self::MAX_QUALITY) {
            $item->quality += self::QUALITY_INCREASE;
        }
    }

    private function decreaseQuality(Item $item): void
    {
        if ($item->quality > self::MIN_QUALITY) {
            $item->quality -= self::QUALITY_DECREASE;
        }
    }

    private function decreaseSellIn(Item $item): void
    {
        $item->sellIn--;
    }

    private function resetQuality(Item $item): void
    {
        $item->quality = self::MIN_QUALITY;
    }

    private function isSulfuras(Item $item): bool
    {
        return $item->name === self::SULFURAS;
    }

    private function isAgedBrie(Item $item): bool
    {
        return $item->name === self::AGED_BRIE;
    }

    private function isBackstagePass(Item $item): bool
    {
        return $item->name === self::BACKSTAGE_PASSES;
    }
}

