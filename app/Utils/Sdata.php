<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

class Sdata
    {
        public static function getaccess($perm)
            {
                $role = DB::table('roles')
                            ->join('permission_role','roles.id', '=', 'permission_role.role_id')
                            ->where("permission_id",$perm)
                            ->select('roles.name')
                            ->get()
                            ->toArray();
                return implode(',',array_column($role,'name'));
            }

        public static function getperm($roleid)
            {
                $perm   = DB::table('permissions')
                    ->join('permission_role','permissions.id', '=', 'permission_role.permission_id')
                    ->where("role_id",$roleid)
                    ->select('permissions.name')
                    ->get()
                    ->toArray();
                //return json_encode($perm);
                return implode(',',array_column($perm,'name'));
            }
    }
