<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExVesselsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ex_vessels')->delete();
        
        \DB::table('ex_vessels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Dijual Tugboat & Barge 300 Ft',
                'description' => '<p>Dijual set Tugboat dan Barge 300 Ft Jumbo, ME : 2 x Mitsubishi 1299 HP, Baru turun Dock Class BKI</p>',
                'grt' => 'GRT 188 / 3793',
                'loa' => '-',
                'dwt' => '-',
                'year' => 'Tahun 2012/2012',
                'engine' => '2 x Mitsubishi 1299 HP',
                'vessel_type' => 8,
                'image' => 'fZ9rIe7J92AwVAcCymfLPgzOqLkikK7WfU9BRabA.jpg',
                'meta_title' => 'Dijual Tugboat & Barge 300 Ft',
                'meta_description' => 'Dijual set Tugboat dan Barge 300 Ft Jumbo, ME : 2 x Mitsubishi 1299 HP, Baru turun Dock Class BKI',
                'meta_keywords' => 'dijual,tugboat,&,barge,300,ft',
                'meta_author' => 'Admin',
                'meta_image' => 'fZ9rIe7J92AwVAcCymfLPgzOqLkikK7WfU9BRabA.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/exvessel/store',
                'meta_robots' => 'index, follow',
                'slug' => 'dijual-tugboat-barge-300-ft',
                'is_sold' => 0,
                'is_active' => 1,
                'created_at' => '2025-06-12 02:51:07',
                'updated_at' => '2025-06-12 02:51:27',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Dijual Tugboat & Tongkang 270 Ft 2010',
                'description' => '<p>Dijual Tugboat &amp; Tongkang 270 Ft, Tahun 2009/2010, Class GL &amp; BKI +A100, ME 2 x Yanmar 610 KW</p>',
                'grt' => 'GRT 202 / 2261',
                'loa' => '26 / 82.30 m',
                'dwt' => '-',
                'year' => 'Tahun 2009 / 2010',
                'engine' => '2 x Yanmar 610KW',
                'vessel_type' => 8,
                'image' => 'Rpi9eSYwTZ91kwcd6cvsklGRqLO913Mc2mP0OcCh.jpg',
                'meta_title' => 'Dijual Tugboat & Tongkang 270 Ft 2010',
                'meta_description' => 'Dijual Tugboat &amp; Tongkang 270 Ft, Tahun 2009/2010, Class GL &amp; BKI +A100, ME 2 x Yanmar 610 KW',
                'meta_keywords' => 'dijual,tugboat,&,tongkang,270,ft,2010',
                'meta_author' => 'Admin',
                'meta_image' => 'Rpi9eSYwTZ91kwcd6cvsklGRqLO913Mc2mP0OcCh.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/exvessel/store',
                'meta_robots' => 'index, follow',
                'slug' => 'dijual-tugboat-tongkang-270-ft-2010',
                'is_sold' => 0,
                'is_active' => 1,
                'created_at' => '2025-06-12 06:28:12',
                'updated_at' => '2025-06-12 06:28:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Dijual Tugboat & Barge 300 Ft Jumbo 2011',
                'description' => '<p>Dijual Tugboat &amp; Barge 300 Ft Jumbo, TB Class NKK &amp; BG Class GL+BKI +A100, ME 2 x Yanmar 1000HP, Rampdoor &amp; Side Board, Dock Terakhir Mei 2019</p>',
                'grt' => '266 / 3772',
                'loa' => '30 / 91.44',
                'dwt' => '-',
                'year' => '2011 / 2011',
                'engine' => '2 x Yanmar 1000HP',
                'vessel_type' => 8,
                'image' => '2OhnThVvx8Na9oqeteMbxU9vP6iKrZ2XbCHjkLGA.jpg',
                'meta_title' => 'Dijual Tugboat & Barge 300 Ft Jumbo 2011',
                'meta_description' => 'Dijual Tugboat &amp; Barge 300 Ft Jumbo, TB Class NKK &amp; BG Class GL+BKI +A100, ME 2 x Yanmar 1000HP, Rampdoor &amp; Side Board, Dock Terakhir Mei...',
                'meta_keywords' => 'dijual,tugboat,&,barge,300,ft,jumbo,2011',
                'meta_author' => 'Admin',
                'meta_image' => '2OhnThVvx8Na9oqeteMbxU9vP6iKrZ2XbCHjkLGA.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/exvessel/store',
                'meta_robots' => 'index, follow',
                'slug' => 'dijual-tugboat-barge-300-ft-jumbo-2011',
                'is_sold' => 0,
                'is_active' => 1,
                'created_at' => '2025-06-12 06:30:42',
                'updated_at' => '2025-06-12 06:31:38',
            ),
            3 => 
            array (
                'id' => 4,
            'title' => 'Self-Propelled Oil Barge (SPOB) 2012 - 2013',
                'description' => '<p>Dijual SPOB Tahun 2012-2013 LOA. 42,50 m, ME 2 x Yanmar Marine Engine Model 6HA2M-WDT, 405PS @1950rpm, Propeller Four-blades bronze, Port Of Register Samarinda</p>',
                'grt' => '-',
                'loa' => '42,50',
                'dwt' => '-',
                'year' => '2013',
                'engine' => '2 x Yanmar Marine Engine Model 6HA2M-WDT, 405PS @1950rpm',
                'vessel_type' => 9,
                'image' => 'j5b0WmJ4D9l8RXSOtQlA1Y5zqZyCC6bJvWCy6UrE.jpg',
            'meta_title' => 'Self-Propelled Oil Barge (SPOB) 2012 - 2013',
                'meta_description' => 'Dijual SPOB Tahun 2012-2013 LOA. 42,50 m, ME 2 x Yanmar Marine Engine Model 6HA2M-WDT, 405PS @1950rpm, Propeller Four-blades bronze, Port Of Register...',
            'meta_keywords' => 'self-propelled,oil,barge,(spob),2012,-,2013',
                'meta_author' => 'Admin',
                'meta_image' => 'j5b0WmJ4D9l8RXSOtQlA1Y5zqZyCC6bJvWCy6UrE.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/exvessel/store',
                'meta_robots' => 'index, follow',
                'slug' => 'self-propelled-oil-barge-spob-2012-2013',
                'is_sold' => 0,
                'is_active' => 1,
                'created_at' => '2025-06-12 06:33:41',
                'updated_at' => '2025-06-12 06:35:04',
            ),
        ));
        
        
    }
}