<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AboutsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('abouts')->delete();
        
        \DB::table('abouts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'PT Arjaya Berkah Marine',
                'description' => '<p>Arjaya Berkah Marine adalah perusahaan galangan untuk perbaikan dan pembangunan kapal baru dan alat apung lainnya,berlokasi di pantai Utara Pulau Jawa berjarak 5 Km dari pelabuhan Merak dan Kawasan PLTU Suralaya.</p>

<p>Arjaya Berkah Marine berdiri pada awal tahun 2019 dan dikomandoi oleh tenaga profesional yang telah berpengalaman dibidang kemaritiman.</p>

<p>Arjaya marine menempati lahan seluas 3 Ha yang siap digunakan area docking kapal dan pembangunan kapal baru.</p>',
                'meta_title' => 'PT Arjaya Berkah Marine',
                'meta_description' => 'Arjaya Berkah Marine adalah perusahaan galangan untuk perbaikan dan pembangunan kapal baru dan alat apung lainnya,berlokasi di pantai Utara Pulau Jawa...',
                'meta_keywords' => 'pt,arjaya,berkah,marine',
                'meta_author' => 'Admin',
                'meta_image' => NULL,
                'meta_canonical' => 'http://192.168.56.3:8012/admin/aboutus/store',
                'meta_robots' => 'index, follow',
                'slug' => 'pt-arjaya-berkah-marine',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:33:06',
                'updated_at' => '2025-06-09 16:33:06',
            ),
        ));
        
        
    }
}