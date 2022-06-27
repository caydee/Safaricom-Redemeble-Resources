<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
    {
        use HasFactory;
        public function products()
            {
                return $this->hasManyThrough(Product::class,Org_Product::class);
            }

        public function user()
            {
                return $this->belongsTo(User::class);
            }

        public function parent()
            {
                return $this->belongsTo(Organization::class,'parent_id');
            }

        public function children()
            {
                return $this->hasMany(self::class, 'parent_id');
            }

        public function grandchildren()
            {
                return $this->children()->with('grandchildren');
            }
    }
