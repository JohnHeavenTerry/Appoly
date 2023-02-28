<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonAbility extends Model
{
    protected $guarded = ['id'];
    protected $table = 'pokemon_ability';
    use HasFactory;
}
