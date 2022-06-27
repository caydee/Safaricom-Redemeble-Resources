<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
    {
        use HasFactory;
        protected $table = 'permission_role';
        public function role()
            {
                return $this->belongsTo(Role::class);
            }
        public function permission()
            {
               return $this->belongsTo(Permission::class) ;
            }
    }
