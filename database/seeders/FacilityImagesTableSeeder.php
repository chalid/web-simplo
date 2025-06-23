<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FacilityImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('facility_images')->delete();
        
        \DB::table('facility_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'facility_id' => 1,
                'uri' => 'Bj5YMhudAGDWruFbDFHVJK6qcBYiHUj1Mr6xxt2z.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:31:41',
                'updated_at' => '2025-06-12 02:31:41',
            ),
            1 => 
            array (
                'id' => 2,
                'facility_id' => 2,
                'uri' => 'JSM7n2JSHxr9mogTONYOrLyngkncqT0TU9kABNsr.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:32:12',
                'updated_at' => '2025-06-12 02:32:12',
            ),
            2 => 
            array (
                'id' => 3,
                'facility_id' => 3,
                'uri' => 'sqMTUTwB0ZJXNXXCk7XWEolL7Nmt0l7iiCxmCX2J.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:32:57',
                'updated_at' => '2025-06-12 02:32:57',
            ),
            3 => 
            array (
                'id' => 4,
                'facility_id' => 4,
                'uri' => 'ZFHSwiXIEnA4UBHEeJAhkS1entM5TYzw7gmZgWQ1.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:33:28',
                'updated_at' => '2025-06-12 02:33:28',
            ),
            4 => 
            array (
                'id' => 5,
                'facility_id' => 5,
                'uri' => 'BCNBDCD1j2USNCnJsiKhaEBZeMzJYjtuVADSsuBf.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:34:11',
                'updated_at' => '2025-06-12 02:34:11',
            ),
        ));
        
        
    }
}