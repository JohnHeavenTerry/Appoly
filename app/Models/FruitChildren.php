<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitChildren extends Model
{
    protected $table = 'fruit_children';

    protected $fillable = ['name', 'fruit_id', 'item_type', 'item'];

    use HasFactory;

    public function scopeHasType($query) {
        $query->whereNotNull('item_type');
    }
}
