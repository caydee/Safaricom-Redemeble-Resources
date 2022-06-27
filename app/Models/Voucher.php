<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model

    {
        use HasFactory;
        protected $fillable = ['voucher','batch_id','product_id','organization_id','active','expired'];



        public function organization()
            {
                return $this->belongsTo('App\Models\Organization','organization_id','id');
            }
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
    }
