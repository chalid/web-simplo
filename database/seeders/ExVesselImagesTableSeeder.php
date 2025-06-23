<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExVesselImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ex_vessel_images')->delete();
        
        \DB::table('ex_vessel_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ex_vessel_id' => 1,
                'uri' => 'LyGpuJ5ATtsC16qIIy0BbhTyRtC1VyNvqxgR22os.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 02:51:08',
                'updated_at' => '2025-06-12 02:51:27',
            ),
            1 => 
            array (
                'id' => 2,
                'ex_vessel_id' => 1,
                'uri' => 'fZ9rIe7J92AwVAcCymfLPgzOqLkikK7WfU9BRabA.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:51:27',
                'updated_at' => '2025-06-12 02:51:27',
            ),
            2 => 
            array (
                'id' => 3,
                'ex_vessel_id' => 2,
                'uri' => 'G00xspyVI1jVBAlaK5SPOTQH3EtRSIGKXtsIoBp6.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:28:13',
                'updated_at' => '2025-06-12 06:28:39',
            ),
            3 => 
            array (
                'id' => 4,
                'ex_vessel_id' => 2,
                'uri' => 'Rpi9eSYwTZ91kwcd6cvsklGRqLO913Mc2mP0OcCh.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 06:28:39',
                'updated_at' => '2025-06-12 06:28:39',
            ),
            4 => 
            array (
                'id' => 5,
                'ex_vessel_id' => 3,
                'uri' => 'pZKIMPvXGBJJIRMkmxKcwGYBuxGos5D1mJ3EGVbU.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:30:42',
                'updated_at' => '2025-06-12 06:31:12',
            ),
            5 => 
            array (
                'id' => 6,
                'ex_vessel_id' => 3,
                'uri' => 'TFw5Yfu1GKQc5SC10cfucnhAT6Zes1lwE0BYlGof.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:31:12',
                'updated_at' => '2025-06-12 06:31:38',
            ),
            6 => 
            array (
                'id' => 7,
                'ex_vessel_id' => 3,
                'uri' => '2OhnThVvx8Na9oqeteMbxU9vP6iKrZ2XbCHjkLGA.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 06:31:38',
                'updated_at' => '2025-06-12 06:31:38',
            ),
            7 => 
            array (
                'id' => 8,
                'ex_vessel_id' => 4,
                'uri' => 'j5b0WmJ4D9l8RXSOtQlA1Y5zqZyCC6bJvWCy6UrE.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 06:33:42',
                'updated_at' => '2025-06-12 06:35:04',
            ),
            8 => 
            array (
                'id' => 9,
                'ex_vessel_id' => 4,
                'uri' => 'hlLcygaIgd0qQ57NMFW0mLSOjNrFomlamzRtHCXU.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:34:15',
                'updated_at' => '2025-06-12 06:34:42',
            ),
            9 => 
            array (
                'id' => 10,
                'ex_vessel_id' => 4,
                'uri' => 'OTmyoxEqTotnKUE5QsJFr50PwB1wljb4DWJF2FFl.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:34:42',
                'updated_at' => '2025-06-12 06:34:58',
            ),
            10 => 
            array (
                'id' => 11,
                'ex_vessel_id' => 4,
                'uri' => 'DwwT5pnAOSLazGzZLn7nAPCwpzlv5TK1hisYA23Q.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 06:34:58',
                'updated_at' => '2025-06-12 06:35:04',
            ),
        ));
        
        
    }
}