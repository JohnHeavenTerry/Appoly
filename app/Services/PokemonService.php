<?php

namespace App\Services;

use App\Models\{Moves, Types, Ability, PokemonMoves, PokemonAbility, PokemonTypes, PokemonDetails};
use App\Services\{ AbilityService, MoveService};
class PokemonService
{
    /**
     * @return mixed
     * Returns pokemon data
     * formatted for frontend
     */
    public function getPokemonData() {
       return PokemonDetails::get()
                            ->map(function ($pokemon) {
                                $abilityArray = [];
                                $moveArray = [];

                                $abilities = $pokemon->abilities;
                                $moves = $pokemon->moves;

                                foreach($abilities as $k => $ability) {
                                    $abilityArray[$k] = $ability->ability_name;
                                }

                                foreach($moves as $k => $move) {
                                    $moveArray[$k] = $move->move_name;
                                }

                                $finalArray = [
                                    'id' => $pokemon->id,
                                    'pokemon' => $pokemon,
                                    'abilities' => $abilityArray,
                                    'moves' => $moveArray
                                ];

                                return $finalArray;
                            });
    }

    /**
     * @param $pokemon
     * @return void
     * Calls all required functions
     * to save pokemon API Data
     */
    public function savePokemonData($pokemon) {
        $newPokemon = self::saveNewPokemon($pokemon);
        (new AbilityService())->saveAbility($pokemon['abilities'], $newPokemon);
        (new MoveService())->saveMoves($pokemon['moves'], $newPokemon);
    }

    /**
     * @param $pokemon
     * @return mixed
     * Saves basic stats for
     * given pokemon
     */
    public function saveNewPokemon($pokemon) {
        $stats = self::formatStats($pokemon['stats']);

        $newPokemon = PokemonDetails::firstOrCreate([
            'name' => $pokemon['forms'][0]['name'],
            'hp' => $stats['hp'],
            'attack' => $stats['attack'],
            'defense' => $stats['defense'],
            'special-attack' => $stats['special-attack'],
            'special-defense' => $stats['special-defense'],
            'speed' => $stats['speed'],
            'height' => $pokemon['height'],
            'weight' => $pokemon['weight']
        ]);

        return $newPokemon;
    }

    /**
     * @param $statTypes
     * @return array
     * Function that will sort stats into
     * more managable array
     */
    public function formatStats($statTypes) {
        foreach($statTypes as $stats) {
            $statsArray[$stats['stat']['name']] = $stats['base_stat'];
        }
        return $statsArray;
    }
}
