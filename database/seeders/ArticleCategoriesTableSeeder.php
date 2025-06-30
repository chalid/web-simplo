<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article_categories')->delete();
        
        \DB::table('article_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Visitor Management System',
                'description' => 'Visitor Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:10:39',
                'updated_at' => '2025-06-26 17:10:39',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Room Booking System',
                'description' => 'Room Booking System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:10:51',
                'updated_at' => '2025-06-26 17:10:51',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Computerized Maintanance Management System',
                'description' => 'Computerized Maintanance Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:11:12',
                'updated_at' => '2025-06-26 17:11:12',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Locker Management System',
                'description' => 'Locker Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:11:31',
                'updated_at' => '2025-06-26 17:11:31',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Parking Management System',
                'description' => 'Parking Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:12:14',
                'updated_at' => '2025-06-26 17:12:14',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Stock Management System',
                'description' => 'Stock Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:12:27',
                'updated_at' => '2025-06-26 17:12:27',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Document Management System',
                'description' => 'Document Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:12:39',
                'updated_at' => '2025-06-26 17:12:39',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'School Pick Up Management System',
                'description' => 'School Pick Up Management System',
                'slug' => NULL,
                'created_at' => '2025-06-26 17:12:53',
                'updated_at' => '2025-06-26 17:12:53',
            ),
        ));
        
        
    }
}