<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\FruitChildren;
use Illuminate\Support\Facades\Https;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FruitController extends Controller
{
    /**
     * Returns the fruit page
     * passes $fruits from Fruits Table
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fruitIndex(Request $request) {
        $fruits = Fruit::orderBy('type')->with(array('children' => function($query) {
            $query->orderBy('name', 'DESC');
        }))->get();

        return view('fruit')->with(['fruits' => $fruits]);
    }

    /**
     * Create Fruit adds new Fruit
     * Takes In Name Of Fruit
     * @param Request $request
     * @return void
     */
    public function createFruit(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'sometimes',
            'item' => 'sometimes',
            'item_type' => 'sometimes'
        ]);

        if($validated) {
            if(!Fruit::where('type', $request->name)->exists()) {
                $fruit = new Fruit;
                $fruit->type = $request->input('name');
                $fruit->save();
            } else {
                $fruit = Fruit::firstWhere('type', $request->name);
            }

            if($request->type) {
                $this->makeNewFruitChild($request->type, $request->item, $request->item_type, $fruit->id);
            }
        }
        return response('New Fruit Created', 200);
    }

    /**
     * Remove Fruit takes in
     * ID from Blade to remove.
     * TYPE from blade to change functionality
     * @param Request $request
     * @return void
     */
    public function removeFruit(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string'
        ]);

        if($validated) {
            $allChildren = [];
            switch ($request->type) {
                case 'fruit':
                    $fruit = Fruit::find($request->id);
                    $allChildren = $fruit->children;
                    $fruit->delete();
                    break;

                case 'name':
                    $name = FruitChildren::find($request->id)->name;
                    $allChildren = FruitChildren::where('name', $name)->get();
                    break;

                case 'item':
                    FruitChildren::find($request->id)->delete();
                    break;
            }
            foreach($allChildren as $child) {
                $child->delete();
            }

            return response('success', 200);
        }
    }

    /** Grabs contents from Json Endpoint
     *  For fruit data
     * @param Request $request
     * @return array
     */
    public function getJsonFruit(Request $request) {
        try {
            $response = file_get_contents('https://dev.shepherds-mountain.appoly.io/fruit.json');
            $collectionFruit = collect(json_decode($response));
            $fruits = $collectionFruit->flatten(3);
        } catch(Exception $error) {
            dd($error);
        }

        // Save the result in the model to be loaded into the page
        foreach($fruits as $fruit) {
            // Stop Duplicate Fruit Categories from being created.
            if(Fruit::where('type', $fruit->label)->exists()) {
                $fruitCategory = Fruit::firstWhere('type', $fruit->label);
            } else {
                $fruitCategory = Fruit::create([
                    'type' => $fruit->label
                ]);
            }
            // Sort through each level of Json Array into Table
            foreach($fruit->children as $type) {
                if(!$type->children) {
                    self::makeNewFruitChild($type->label, '', '', $fruitCategory->id);}
                foreach($type->children as $item) {
                    if(!$item->children) self::makeNewFruitChild($type->label, $item->label, '', $fruitCategory->id);
                    foreach($item->children as $flavour) {
                        self::makeNewFruitChild($type->label, $item->label, $flavour->label, $fruitCategory->id);
                    }
                }
            }
        }
    }

    /**
     * @param $name
     * @param $item
     * @param $item_type
     * @param $fruit_id
     * @saves new FruitChild Row
     */
    public function makeNewFruitChild($name, $item, $item_type, $fruit_id) {
        if(!FruitChildren::where('name', $name)->where('item', $item)->where('item_type', $item_type)->where('fruit_id', $fruit_id)->exists()) {
            $fruitChild = new FruitChildren;
            $fruitChild->name = $name;
            $fruitChild->item = $item;
            $fruitChild->item_type = $item_type;
            $fruitChild->fruit_id = $fruit_id;
            $fruitChild->save();
        } else {
            return response('Already Exists', 422);
        }
    }
}
