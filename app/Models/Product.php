<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function type()
        {
            return $this->belongsTo(ProductType::class,'product_type_id','id');
        }
    public function access()
        {
            return $this->belongsTo(AccessType::class,'access_type_id','id');
        }
}
