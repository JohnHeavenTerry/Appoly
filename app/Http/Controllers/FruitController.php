<?php

namespace App\Http\Controllers;

use App\Models\{
    Fruit,
    FruitChildren,
    FruitProduct,
    FruitProductTypes,
};

use App\Services\FruitService;

use Illuminate\{
    Support\Facades\Https,
    Http\Request,
    Supprt\Facades\Input
};

class FruitController extends Controller
{
    public FruitService $fruitService;

    /**
     * Returns the fruit page
     * passes $fruits from Fruits Table
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function fruitIndex(Request $request) {
        $fruits = new FruitService;
        return view('fruit')->with(['fruits' => $fruits->fruitData()]);
    }

    /**
     * Create Fruit adds new Fruit
     * Takes In Name Of Fruit as requirement
     * for new or existing entires.
     *
     * further use into creation of
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

            /*
             * Make new fruit child if entries have been passed.
             * This allows us to add other categories to existing
             * Fruits on the Frontend using the same Interface.
             */
            if($request->type) {
                $fruitService = new FruitService;
                $fruitService->makeNewFruitChild($request->type, $request->item, $request->item_type, $fruit->id);
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
            'name' => 'required|string',
            'type' => 'required|string'
        ]);
        if($validated) {
            switch ($request->type) {
                case 'fruit':
                    $fruit = Fruit::firstWhere('type', $request->name);
                    $allChildren = $fruit->children;
                    $fruit->delete();
                    break;

                case 'category':
                    $allChildren = FruitChildren::firstWhere('name', $request->name)->get();
                    if($allChildren) {
                        foreach ($allChildren as $child) {
                            $child->delete();
                        }
                    }
                    break;

                case 'products':
                case 'type':
                    FruitProductTypes::firstWhere('item_type', $request->name)->delete();
                    break;
            }

            return response('success', 200);
        }
    }

    /** Grabs contents from Json Endpoint
     *  For fruit data and add to the database
     * @param Request $request
     * @return array
     */
    public function getJsonFruit(Request $request) {
        try {
            $response = file_get_contents('https://dev.shepherds-mountain.appoly.io/fruit.json');
            $collectionFruit = collect(json_decode($response));
            $fruits = $collectionFruit->flatten(3);
            $fruitService = new FruitService;
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
                    $fruitService->makeNewFruitChild($type->label, '', '', $fruitCategory->id);
                }
                foreach($type->children as $item) {
                    if(!$item->children) $fruitService->makeNewFruitChild($type->label, $item->label, '', $fruitCategory->id);
                    foreach($item->children as $flavour) {
                        $fruitService->makeNewFruitChild($type->label, $item->label, $flavour->label, $fruitCategory->id);
                    }
                }
            }
        }
    }
}
