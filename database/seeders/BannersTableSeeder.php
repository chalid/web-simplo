<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banners')->delete();
        
        \DB::table('banners')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'WINCH',
                'description' => 'WINCH',
                'image' => 'pE7f8wh4SIkoY42hLR3CMPki5cfteUOalNoKDBMa.jpg',
                'meta_title' => 'WINCH',
                'meta_description' => 'WINCH',
                'meta_keywords' => 'winch',
                'meta_author' => 'Admin',
                'meta_image' => 'pE7f8wh4SIkoY42hLR3CMPki5cfteUOalNoKDBMa.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/banner/store',
                'meta_robots' => 'index, follow',
                'slug' => 'winch',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:33:52',
                'updated_at' => '2025-06-09 16:33:56',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'DOCKING AREA',
                'description' => 'DOCKING AREA',
                'image' => 'D1ZTYUVD80cVgRhk8XVn48sjWtqYBLoz4wJImMpz.jpg',
                'meta_title' => 'DOCKING AREA',
                'meta_description' => 'DOCKING AREA',
                'meta_keywords' => 'docking,area',
                'meta_author' => 'Admin',
                'meta_image' => 'D1ZTYUVD80cVgRhk8XVn48sjWtqYBLoz4wJImMpz.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/banner/store',
                'meta_robots' => 'index, follow',
                'slug' => 'docking-area',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:34:54',
                'updated_at' => '2025-06-09 16:34:56',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'LOPOR',
                'description' => 'LOPOR',
                'image' => 'f3tvuYZIIW3jCGQlp8ikUTIEn2HK54bdfd8YGcjE.jpg',
                'meta_title' => 'LOPOR',
                'meta_description' => 'LOPOR',
                'meta_keywords' => 'lopor',
                'meta_author' => 'Admin',
                'meta_image' => 'f3tvuYZIIW3jCGQlp8ikUTIEn2HK54bdfd8YGcjE.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/banner/store',
                'meta_robots' => 'index, follow',
                'slug' => 'lopor',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:35:29',
                'updated_at' => '2025-06-09 16:35:31',
            ),
        ));
        
        
    }
}