<?php

namespace App\Services;

use App\Models\{Fruit, FruitChildren, FruitProductTypes, FruitProduct};

use Illuminate\{Http\Request, Support\Facades\Https, Supprt\Facades\Input};

class FruitService
{
    /**
     * @param $name
     * @param $item
     * @param $item_type
     * @param $fruit_id
     * @saves new FruitChild
     */
    public function makeNewFruitChild($name, $item, $item_type, $fruit_id) {
        $fruitProductType = [];
        // Set or grab existing Product types

        if($item_type != "") {
            $fruitProductType = FruitProductTypes::where('item_type', $item_type)->exists() ?
                FruitProductTypes::firstWhere('item_type', $item_type)
                : FruitProductTypes::create([
                    'item_type' => $item_type
                ]);
        }

        if($item != "") {
            $fruitProduct = FruitProduct::where('item', $item)
                ->when($fruitProductType != null, function ($q) use ($fruitProductType) {
                    $q->where('item_type_id', $fruitProductType->id);
                })
                ->first();

            // Create new or use existing Product
            if(!isset($fruitProduct) && empty($fruitProduct)) {
                $fruitProduct = FruitProduct::create([
                    'item' => $item,
                    'item_type_id' => $fruitProductType->id ?? null
                ]);
            }
        }
        // Create Child of Fruit Category
         FruitChildren::create([
            'name' => $name,
            'item_id' => $fruitProduct->id ?? null,
            'fruit_id' => $fruit_id
        ]);
    }

    /**
     * Gets fruit data formatted for fruit blade
     * @return array
     */
    public function fruitData() {
        $fruits = Fruit::with('children')
            ->get()
            ->map(function($fruit) {
            $fruitArray = [];

            $children = FruitChildren::where('fruit_id', $fruit->id)->distinct()->get();
            foreach($children as $k => $child) {
                $item = $child->item;
                if(isset($item->itemType)) {
                    $itemType = $item->itemType;

                    $fruitArray[$k] = [
                        'name' => $child->name,
                        'item' => $child->item->item ?? '',
                        'type' => $itemType->item_type ?? '',
                    ];
                }
            }

            $fruitArray[$fruit->type] = $fruitArray;
            return [
                'fruit' => $fruit->type,
                'array' => $fruitArray,
            ];
        });

        return array($fruits);
    }
}
