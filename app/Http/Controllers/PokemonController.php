<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;

use http\Env\Response;
use Illuminate\{
    Support\Facades\Https,
    Http\Request,
    Supprt\Facades\Input
};

class PokemonController extends Controller
{
    public PokemonService $fruitService;

    /**
     * Returns the pokedex page
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function pokedexIndex(Request $request) {
        $data = (new PokemonService())->getPokemonData();
        return view('pokedex')->with('pokeData', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     * Direct access to existing pokemon data
     */
    public function getPokemonData(Request $request) {
        return (new PokemonService())->getPokemonData();
    }

    /** Grabs contents from Endpoint
     *  For pokemon data and add to the database
     * @param Request $request
     * @return response
     */
    public function getPokemonFromApi(Request $request)
    {
        $pokemon = [];
        for($i = 1; $i <= 151; $i++) {
            $pokemon = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $i);
            // Save the result in the model to be loaded into the page
                $pokemonService = new PokemonService;
                $pokemonService->savePokemonData(json_decode($pokemon, true));
        }

        return response()->json(['success'], 200);
    }

}
