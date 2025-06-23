<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SysparamsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sysparams')->delete();
        
        \DB::table('sysparams')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sgroup' => 'gender',
                'skey' => 1,
                'svalue' => 'Male',
                'lvalue' => 'Male',
                'created_at' => '2025-04-22 20:17:40',
                'updated_at' => '2025-04-22 20:20:47',
            ),
            1 => 
            array (
                'id' => 2,
                'sgroup' => 'gender',
                'skey' => 2,
                'svalue' => 'Female',
                'lvalue' => 'Female',
                'created_at' => '2025-04-22 20:20:28',
                'updated_at' => '2025-04-22 20:20:28',
            ),
            2 => 
            array (
                'id' => 3,
                'sgroup' => 'publish',
                'skey' => 0,
                'svalue' => 'Not Publish',
                'lvalue' => 'Not Publish',
                'created_at' => '2025-05-29 06:44:54',
                'updated_at' => '2025-05-29 06:44:54',
            ),
            3 => 
            array (
                'id' => 4,
                'sgroup' => 'publish',
                'skey' => 1,
                'svalue' => 'Publish',
                'lvalue' => 'Publish',
                'created_at' => '2025-05-29 06:45:25',
                'updated_at' => '2025-05-29 06:45:25',
            ),
            4 => 
            array (
                'id' => 5,
                'sgroup' => 'default',
                'skey' => 0,
                'svalue' => 'Not Default',
                'lvalue' => 'Not Default',
                'created_at' => '2025-05-29 06:45:58',
                'updated_at' => '2025-05-29 06:45:58',
            ),
            5 => 
            array (
                'id' => 6,
                'sgroup' => 'default',
                'skey' => 1,
                'svalue' => 'Default',
                'lvalue' => 'Default',
                'created_at' => '2025-05-29 06:46:12',
                'updated_at' => '2025-05-29 06:46:12',
            ),
            6 => 
            array (
                'id' => 7,
                'sgroup' => 'vessel_type',
                'skey' => 1,
                'svalue' => 'Motor Vessel',
                'lvalue' => 'Motor Vessel',
                'created_at' => '2025-05-29 06:47:31',
                'updated_at' => '2025-05-29 06:47:31',
            ),
            7 => 
            array (
                'id' => 8,
                'sgroup' => 'vessel_type',
                'skey' => 2,
                'svalue' => 'Motor Tanker',
                'lvalue' => 'Motor Tanker',
                'created_at' => '2025-05-29 06:47:48',
                'updated_at' => '2025-05-29 06:47:48',
            ),
            8 => 
            array (
                'id' => 9,
                'sgroup' => 'vessel_type',
                'skey' => 3,
                'svalue' => 'Tug Boat',
                'lvalue' => 'Tug Boat',
                'created_at' => '2025-05-29 06:48:08',
                'updated_at' => '2025-05-29 06:48:08',
            ),
            9 => 
            array (
                'id' => 10,
                'sgroup' => 'vessel_type',
                'skey' => 4,
                'svalue' => 'Barge',
                'lvalue' => 'Barge',
                'created_at' => '2025-05-29 06:48:25',
                'updated_at' => '2025-05-29 06:48:25',
            ),
            10 => 
            array (
                'id' => 11,
                'sgroup' => 'vessel_type',
                'skey' => 5,
                'svalue' => 'Kapal Motor Penumpang',
                'lvalue' => 'Kapal Motor Penumpang',
                'created_at' => '2025-05-29 06:48:39',
                'updated_at' => '2025-05-29 06:48:39',
            ),
            11 => 
            array (
                'id' => 12,
                'sgroup' => 'vessel_type',
                'skey' => 6,
                'svalue' => 'Barge Crane',
                'lvalue' => 'Barge Crane',
                'created_at' => '2025-05-29 06:49:01',
                'updated_at' => '2025-05-29 06:49:01',
            ),
            12 => 
            array (
                'id' => 13,
                'sgroup' => 'vessel_type',
                'skey' => 7,
                'svalue' => 'Landing Craft Tank',
                'lvalue' => 'Landing Craft Tank',
                'created_at' => '2025-05-29 06:49:23',
                'updated_at' => '2025-05-29 06:49:23',
            ),
            13 => 
            array (
                'id' => 14,
                'sgroup' => 'vessel_type',
                'skey' => 8,
            'svalue' => 'Tugboat & Barge ( TB & BG )',
            'lvalue' => 'Tugboat & Barge ( TB & BG )',
                'created_at' => '2025-05-29 06:49:57',
                'updated_at' => '2025-05-29 06:49:57',
            ),
            14 => 
            array (
                'id' => 15,
                'sgroup' => 'vessel_type',
                'skey' => 9,
            'svalue' => 'Self Propelled Oil Barge (SPOB)',
            'lvalue' => 'Self Propelled Oil Barge (SPOB)',
                'created_at' => '2025-05-29 06:50:32',
                'updated_at' => '2025-05-29 06:52:17',
            ),
            15 => 
            array (
                'id' => 16,
                'sgroup' => 'product_type',
                'skey' => 1,
                'svalue' => 'New Product',
                'lvalue' => 'New Product',
                'created_at' => '2025-05-29 06:51:16',
                'updated_at' => '2025-05-29 06:52:36',
            ),
            16 => 
            array (
                'id' => 17,
                'sgroup' => 'product_type',
                'skey' => 2,
                'svalue' => 'Equipment & Safety',
                'lvalue' => 'Equipment & Safety',
                'created_at' => '2025-05-29 06:52:55',
                'updated_at' => '2025-05-29 06:52:55',
            ),
            17 => 
            array (
                'id' => 18,
                'sgroup' => 'is_sold',
                'skey' => 0,
                'svalue' => 'Available',
                'lvalue' => 'Available',
                'created_at' => '2025-05-29 06:53:29',
                'updated_at' => '2025-05-29 06:53:29',
            ),
            18 => 
            array (
                'id' => 19,
                'sgroup' => 'is_sold',
                'skey' => 1,
                'svalue' => 'Sold Out',
                'lvalue' => 'Sold Out',
                'created_at' => '2025-05-29 06:53:46',
                'updated_at' => '2025-05-29 06:53:46',
            ),
        ));
        
        
    }
}