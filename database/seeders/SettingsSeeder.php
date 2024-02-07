<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         DB::table('settings')->insert([
            [
                'key'=>'app_name',
                'value'=>'test_app',

            ],
            [
                'key'=>'date_format',
                'value'=>'d-m-Y',

            ],

            [
                'key'=>'pagination_limit',
                'value'=>'10',

            ],
            
            ]);
    }
}
