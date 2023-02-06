<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\FruitFactory;
use App\Models\FruitProduct;
use App\Models\FruitChildren;

class Fruit extends Model
{
    use HasFactory;

    protected $table = 'fruits';
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products() {
        return $this->hasManyThrough(FruitProduct::class, FruitChildren::class, 'item_id', 'id');
    }

    public function scopeOrderByFruit($query) {
        return $query->whereHas('products', function($q) {
            $q->orderBy('name', 'ASC');
        });
    }
}
