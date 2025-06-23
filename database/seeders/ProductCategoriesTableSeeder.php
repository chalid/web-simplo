<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_categories')->delete();
        
        \DB::table('product_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Border',
                'description' => 'Border',
                'code' => 'BD',
                'created_at' => '2025-06-05 06:57:04',
                'updated_at' => '2025-06-05 06:57:04',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Propeller',
                'description' => 'Propeller',
                'code' => 'PP',
                'created_at' => '2025-06-05 06:57:23',
                'updated_at' => '2025-06-05 06:57:23',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Speed Boat',
                'description' => 'Speed Boat',
                'code' => 'SB',
                'created_at' => '2025-06-05 06:57:39',
                'updated_at' => '2025-06-05 06:57:39',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Buoy',
                'description' => 'Buoy',
                'code' => 'BO',
                'created_at' => '2025-06-05 06:57:52',
                'updated_at' => '2025-06-05 06:57:52',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Docking',
                'description' => 'Docking',
                'code' => 'DC',
                'created_at' => '2025-06-05 06:58:08',
                'updated_at' => '2025-06-05 06:58:08',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Kapal Bangunan Baru',
                'description' => 'Kapal Bangunan Baru',
                'code' => 'KBB',
                'created_at' => '2025-06-05 06:58:21',
                'updated_at' => '2025-06-05 06:58:21',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Rubber Airbag',
                'description' => 'Rubber Airbag',
                'code' => 'RA',
                'created_at' => '2025-06-05 06:58:36',
                'updated_at' => '2025-06-05 06:58:36',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Mooring Buoy',
                'description' => 'Mooring Buoy',
                'code' => 'MB',
                'created_at' => '2025-06-05 06:58:50',
                'updated_at' => '2025-06-05 06:58:50',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Anchor',
                'description' => 'Anchor',
                'code' => 'AC',
                'created_at' => '2025-06-05 06:59:01',
                'updated_at' => '2025-06-05 06:59:01',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Crane',
                'description' => 'Crane',
                'code' => 'CR',
                'created_at' => '2025-06-05 06:59:13',
                'updated_at' => '2025-06-05 06:59:13',
            ),
            10 => 
            array (
                'id' => 11,
            'name' => 'Self-Propelled Oil Barge (SPOB)',
            'description' => 'Self-Propelled Oil Barge (SPOB)',
                'code' => 'SPOB',
                'created_at' => '2025-06-05 06:59:51',
                'updated_at' => '2025-06-05 06:59:51',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Hybrid Engine',
                'description' => 'Hybrid Engine',
                'code' => 'HE',
                'created_at' => '2025-06-05 07:00:12',
                'updated_at' => '2025-06-05 07:00:12',
            ),
        ));
        
        
    }
}