<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgProduct extends Model
    {
        use HasFactory;
    protected $hidden = [
        'password',
        'remember_token',
    ];
        public function organization()
            {
                return $this->belongsTo(Organization::class);
            }
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
        public function access_type()
            {
                return $this->belongsTo(AccessType::class);
            }
        public function produnits($orgid,$prodid)
            {
                return OrgUnits::where('organization_id',$orgid)
                                ->where('product_id',$prodid)
                                ->first();
            }
    }
