<?php

namespace GildedRose\Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /** @test */
    public function normalItemBeforeSellDate(): void
    {
        $items = [new Item('Normal Item', 10, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(9, $items[0]->sellIn);
        $this->assertEquals(19, $items[0]->quality);
    }

    /** @test */
    public function normalItemAfterSellDate(): void
    {
        $items = [new Item('Normal Item', -1, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(-2, $items[0]->sellIn);
        $this->assertEquals(18, $items[0]->quality);
    }

    /** @test */
    public function qualityNeverNegative(): void
    {
        $items = [new Item('Normal Item', 10, 0)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(0, $items[0]->quality);
    }

    /** @test */
    public function agedBrieIncreasesQuality(): void
    {
        $items = [new Item('Aged Brie', 10, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(9, $items[0]->sellIn);
        $this->assertEquals(21, $items[0]->quality);
    }

    /** @test */
    public function agedBrieAfterSellDate(): void
    {
        $items = [new Item('Aged Brie', -1, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(-2, $items[0]->sellIn);
        $this->assertEquals(22, $items[0]->quality);
    }

    /** @test */
    public function qualityNeverAbove50(): void
    {
        $items = [new Item('Aged Brie', 10, 50)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
    }

    /** @test */
    public function sulfurasNeverChanges(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 80)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(10, $items[0]->sellIn);
        $this->assertEquals(80, $items[0]->quality);
    }

    /** @test */
    public function backstagePassesMoreThan10Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(14, $items[0]->sellIn);
        $this->assertEquals(21, $items[0]->quality);
    }

    /** @test */
    public function backstagePassesWith10Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(9, $items[0]->sellIn);
        $this->assertEquals(22, $items[0]->quality);
    }

    /** @test */
    public function backstagePassesWith5Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(4, $items[0]->sellIn);
        $this->assertEquals(23, $items[0]->quality);
    }

    /** @test */
    public function backstagePassesAfterConcert(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 20)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertEquals(-1, $items[0]->sellIn);
        $this->assertEquals(0, $items[0]->quality);
    }
}

