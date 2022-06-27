<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new User)->upsert([
            [
                'name'              =>  'Dennis Kiptoo',
                'email'             =>  'caydee209@gmail.com',
                'password'          =>  bcrypt('15442'), // password
                'email_verified_at' =>  now()->format('Y-m-d H:i:s'),
                'status'            =>  1,
                'remember_token'    =>  Str::random(10),
                'organization_id'   =>  1,
                'phone_no'          =>  '+254713154085'
            ],

        ], ['email'], ['name','password' ,'email_verified_at', 'remember_token','organization_id','phone_no']);

    }
}
