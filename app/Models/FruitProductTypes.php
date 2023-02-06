<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitProductTypes extends Model
{
    protected $table = 'fruit_product_types';

    protected $fillable = ['item_type'];

    use HasFactory;
}
