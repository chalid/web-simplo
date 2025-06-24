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
        ));
        
        
    }
}