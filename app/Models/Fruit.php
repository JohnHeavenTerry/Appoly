<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\FruitFactory;

class Fruit extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return FruitFactory::new();
    }

    /**
     * Get all the fruit children.
     */
    public function children()
    {
        return $this->hasMany(FruitChildren::class);
    }

}
