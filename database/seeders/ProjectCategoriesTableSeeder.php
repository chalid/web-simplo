<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_categories')->delete();
        
        \DB::table('project_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Docking',
                'description' => 'Ships Repair',
                'created_at' => '2025-06-05 07:00:33',
                'updated_at' => '2025-06-05 07:01:29',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Floating Repair',
                'description' => 'Perbaikan Barge diatas air',
                'created_at' => '2025-06-05 07:00:43',
                'updated_at' => '2025-06-05 07:01:14',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Ship Recycling',
                'description' => 'Ship Recycling Facilities',
                'created_at' => '2025-06-05 07:01:00',
                'updated_at' => '2025-06-05 07:01:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Building',
                'description' => 'Pembangunan Baru',
                'created_at' => '2025-06-05 07:02:01',
                'updated_at' => '2025-06-05 07:02:01',
            ),
        ));
        
        
    }
}