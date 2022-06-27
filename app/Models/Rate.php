<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
    {
        use HasFactory;
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
        public function organization()
            {
                return $this->belongsTo(Organization::class);
            }
    }
