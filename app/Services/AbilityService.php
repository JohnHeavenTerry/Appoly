<?php

namespace App\Services;

use App\Models\{Moves, Types, Ability, PokemonMoves, PokemonAbility, PokemonTypes, PokemonDetails};

class AbilityService
{
    /**
     * @param $abilities
     * @param PokemonDetails $pokemon
     * @return void
     * Saves Pokemon Abilities
     * as well as saving the reference
     * for that given pokemon
     */
    public function saveAbility($abilities, PokemonDetails $pokemon) {
        foreach($abilities as $abilityObject) {
            $ability = Ability::firstOrCreate(['ability_name' => $abilityObject['ability']['name']]);

            PokemonAbility::create([
                'ability_id' => $ability->id,
                'pokemon_id' => $pokemon->id
            ]);
        }
    }
}
