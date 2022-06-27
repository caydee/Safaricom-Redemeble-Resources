<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgUnits extends Model
    {
        use HasFactory;
        protected $fillable = ['units','organization_id','product_id'];
        public $timestamps  = TRUE;
        public function  organization()
            {
                return $this->belongsTo(Organization::class);
            }
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
    }
