<?php

require_once __DIR__ . '/vendor/autoload.php';

use GildedRose\GildedRose;
use GildedRose\Item;

echo "GILDED ROSE - EJEMPLO DE FUNCIONAMIENTO\n";
echo "========================================\n\n";

// Crear algunos items de ejemplo
$items = [
    new Item('+5 Dexterity Vest', 10, 20),
    new Item('Aged Brie', 2, 0),
    new Item('Elixir of the Mongoose', 5, 7),
    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
];

$gildedRose = new GildedRose($items);

// Simular 3 días
for ($day = 0; $day < 3; $day++) {
    echo "-------- Día $day --------\n";
    echo "name, sellIn, quality\n";
    
    foreach ($items as $item) {
        echo $item . "\n";
    }
    
    echo "\n";
    $gildedRose->updateQuality();
}

echo "Ejecución completada con éxito! ✓\n";

