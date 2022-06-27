<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUsage extends Model
    {
        use HasFactory;
        protected $fillable = ['org_product_id','msisdn','content','status'];
        public $timestamps = TRUE;
    }
