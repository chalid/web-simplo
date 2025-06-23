<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('facilities')->delete();
        
        \DB::table('facilities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Lopor',
                'description' => '<p>Lopor</p>',
                'image' => 'Bj5YMhudAGDWruFbDFHVJK6qcBYiHUj1Mr6xxt2z.jpg',
                'meta_title' => 'Lopor',
                'meta_description' => 'Lopor',
                'meta_keywords' => 'lopor',
                'meta_author' => 'Admin',
                'meta_image' => 'Bj5YMhudAGDWruFbDFHVJK6qcBYiHUj1Mr6xxt2z.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/facility/store',
                'meta_robots' => 'index, follow',
                'slug' => 'lopor',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:31:41',
                'updated_at' => '2025-06-12 02:31:41',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Mess Karyawan',
                'description' => '<p>Mess Karyawan</p>',
                'image' => 'JSM7n2JSHxr9mogTONYOrLyngkncqT0TU9kABNsr.jpg',
                'meta_title' => 'Mess Karyawan',
                'meta_description' => 'Mess Karyawan',
                'meta_keywords' => 'mess,karyawan',
                'meta_author' => 'Admin',
                'meta_image' => 'JSM7n2JSHxr9mogTONYOrLyngkncqT0TU9kABNsr.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/facility/store',
                'meta_robots' => 'index, follow',
                'slug' => 'mess-karyawan',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:32:12',
                'updated_at' => '2025-06-12 02:32:12',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Area Floating',
                'description' => '<p>Area Floating</p>',
                'image' => 'sqMTUTwB0ZJXNXXCk7XWEolL7Nmt0l7iiCxmCX2J.jpg',
                'meta_title' => 'Area Floating',
                'meta_description' => 'Area Floating',
                'meta_keywords' => 'area,floating',
                'meta_author' => 'Admin',
                'meta_image' => 'sqMTUTwB0ZJXNXXCk7XWEolL7Nmt0l7iiCxmCX2J.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/facility/store',
                'meta_robots' => 'index, follow',
                'slug' => 'area-floating',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:32:57',
                'updated_at' => '2025-06-12 02:32:57',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Winch',
                'description' => '<p>Winch</p>',
                'image' => 'ZFHSwiXIEnA4UBHEeJAhkS1entM5TYzw7gmZgWQ1.jpg',
                'meta_title' => 'Winch',
                'meta_description' => 'Winch',
                'meta_keywords' => 'winch',
                'meta_author' => 'Admin',
                'meta_image' => 'ZFHSwiXIEnA4UBHEeJAhkS1entM5TYzw7gmZgWQ1.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/facility/store',
                'meta_robots' => 'index, follow',
                'slug' => 'winch',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:33:25',
                'updated_at' => '2025-06-12 02:33:28',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Rubber Airbag',
                'description' => '<p>Rubber Airbag</p>',
                'image' => 'BCNBDCD1j2USNCnJsiKhaEBZeMzJYjtuVADSsuBf.jpg',
                'meta_title' => 'Rubber Airbag',
                'meta_description' => 'Rubber Airbag',
                'meta_keywords' => 'rubber,airbag',
                'meta_author' => 'Admin',
                'meta_image' => 'BCNBDCD1j2USNCnJsiKhaEBZeMzJYjtuVADSsuBf.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/facility/store',
                'meta_robots' => 'index, follow',
                'slug' => 'rubber-airbag',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:34:10',
                'updated_at' => '2025-06-12 02:34:11',
            ),
        ));
        
        
    }
}