<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonDetails extends Model
{
    use HasFactory;

    private $id;
    protected $guarded = ['id'];
    protected $table = 'pokemonDetails';

    public function getId() {
        return $this->id;
    }

    /**
     * Returns Abilities
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function abilities() {
        return $this->hasManyThrough('App\Models\Ability','App\Models\PokemonAbility', 'ability_id','id');
    }

    /**
     * Returns Moves
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function moves() {
        return $this->hasManyThrough('App\Models\Moves', 'App\Models\PokemonMoves', 'move_id', 'id');
    }
}
