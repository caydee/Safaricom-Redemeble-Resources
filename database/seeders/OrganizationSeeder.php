<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
            {
                (new Organization)->upsert([
                    [
                        'id'        =>  1,
                        'name'      =>  'Tamaituk',
                        'parent_id' =>  0,
                        'user_id'   =>  1,
                        'status'    =>  1,

                    ],

                ], ['id'], ['name','parent_id','user_id' ,'status']);
            }
    }
