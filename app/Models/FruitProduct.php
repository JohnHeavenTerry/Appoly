<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\FruitProductTypes;

class FruitProduct extends Model
{
    protected $table = 'fruit_product';
    protected $fillable = ['item', 'item_type_id'];

    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne FruitProductType
     */
    public function itemType() {
        return $this->HasOne(FruitProductTypes::class, 'id', 'item_type_id');
    }
}
