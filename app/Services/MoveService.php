<?php

namespace App\Services;

use App\Models\{Moves, Types, Ability, PokemonMoves, PokemonAbility, PokemonTypes, PokemonDetails};

class MoveService
{
    /**
     * Saves each move as well as
     * the direct link between move and
     * pokemon.
     * @param $moves
     * @param PokemonDetails $pokemon
     * @return void
     */
    public function saveMoves($moves, PokemonDetails $pokemon) {
        foreach($moves as $moveObject) {
            $move = Moves::firstOrCreate(['move_name' => $moveObject['move']['name']]);

            PokemonMoves::create([
                'move_id' => $move->id,
                'pokemon_id' => $pokemon->id
            ]);
        }
    }

}
