<?php

namespace GildedRose\Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    // ========================================
    // NORMAL ITEM TESTS
    // ========================================

    public function testNormalItemQualityDecreasesBy1BeforeSellDate(): void
    {
        $items = [new Item('Normal Item', 10, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(19, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }

    public function testNormalItemQualityDecreasesBy2AfterSellDate(): void
    {
        $items = [new Item('Normal Item', 0, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(18, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testNormalItemQualityNeverNegative(): void
    {
        $items = [new Item('Normal Item', 5, 0)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(4, $items[0]->sellIn);
    }

    public function testNormalItemQualityDoesNotGoNegativeAfterSellDate(): void
    {
        $items = [new Item('Normal Item', -1, 1)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(-2, $items[0]->sellIn);
    }

    // ========================================
    // AGED BRIE TESTS
    // ========================================

    public function testAgedBrieIncreasesInQuality(): void
    {
        $items = [new Item('Aged Brie', 10, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(21, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }

    public function testAgedBrieIncreasesBy2AfterSellDate(): void
    {
        $items = [new Item('Aged Brie', 0, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(22, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testAgedBrieQualityNeverExceeds50(): void
    {
        $items = [new Item('Aged Brie', 10, 50)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }

    public function testAgedBrieQualityNeverExceeds50AfterSellDate(): void
    {
        $items = [new Item('Aged Brie', -1, 49)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(-2, $items[0]->sellIn);
    }

    // ========================================
    // BACKSTAGE PASSES TESTS
    // ========================================

    public function testBackstagePassesIncreaseBy1WhenMoreThan10Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(21, $items[0]->quality);
        $this->assertSame(14, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreaseBy2When10DaysOrLess(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(22, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }

    public function testBackstagePassesIncreaseBy3When5DaysOrLess(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(23, $items[0]->quality);
        $this->assertSame(4, $items[0]->sellIn);
    }

    public function testBackstagePassesDropTo0AfterConcert(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(0, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testBackstagePassesQualityNeverExceeds50(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(4, $items[0]->sellIn);
    }

    // ========================================
    // SULFURAS TESTS
    // ========================================

    public function testSulfurasNeverChangesQuality(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 80)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(80, $items[0]->quality);
        $this->assertSame(10, $items[0]->sellIn);
    }

    public function testSulfurasNeverChangesSellIn(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 0, 80)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(80, $items[0]->quality);
        $this->assertSame(0, $items[0]->sellIn);
    }

    public function testSulfurasNeverChangesEvenWithNegativeSellIn(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', -1, 80)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(80, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    // ========================================
    // EDGE CASE TESTS
    // ========================================

    public function testMultipleItemsUpdateCorrectly(): void
    {
        $items = [
            new Item('Normal Item', 5, 10),
            new Item('Aged Brie', 5, 10),
            new Item('Sulfuras, Hand of Ragnaros', 5, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 10),
        ];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(9, $items[0]->quality);
        $this->assertSame(11, $items[1]->quality);
        $this->assertSame(80, $items[2]->quality);
        $this->assertSame(13, $items[3]->quality);
    }

    public function testMultipleDaysSimulation(): void
    {
        $items = [new Item('Normal Item', 2, 10)];
        $gildedRose = new GildedRose($items);
        
        // Day 1: sellIn=1, quality=9
        $gildedRose->updateQuality();
        $this->assertSame(9, $items[0]->quality);
        $this->assertSame(1, $items[0]->sellIn);
        
        // Day 2: sellIn=0, quality=8
        $gildedRose->updateQuality();
        $this->assertSame(8, $items[0]->quality);
        $this->assertSame(0, $items[0]->sellIn);
        
        // Day 3: sellIn=-1, quality=6 (degrades by 2 after sell date)
        $gildedRose->updateQuality();
        $this->assertSame(6, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sellIn);
    }

    public function testBackstagePassesAt6Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 6, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(22, $items[0]->quality);
        $this->assertSame(5, $items[0]->sellIn);
    }

    public function testBackstagePassesAt11Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 11, 20)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(21, $items[0]->quality);
        $this->assertSame(10, $items[0]->sellIn);
    }

    public function testAgedBrieAt49Quality(): void
    {
        $items = [new Item('Aged Brie', 5, 49)];
        $gildedRose = new GildedRose($items);
        
        $gildedRose->updateQuality();
        
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(4, $items[0]->sellIn);
    }
}
