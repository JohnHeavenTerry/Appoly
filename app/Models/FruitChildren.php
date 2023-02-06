<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FruitProduct;

class FruitChildren extends Model
{
    protected $table = 'fruit_children';

    protected $fillable = ['name', 'fruit_id', 'item_id'];

    use HasFactory;

    public function item() {
        return $this->hasOne(FruitProduct::class, 'id', 'item_id');
    }
}
