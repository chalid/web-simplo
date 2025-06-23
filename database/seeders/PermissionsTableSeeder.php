<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'name' => 'Sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:21',
                'updated_at' => '2025-05-29 08:02:21',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 1,
                'name' => 'Can add sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:34',
                'updated_at' => '2025-05-29 08:02:34',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 1,
                'name' => 'Can edit sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:47',
                'updated_at' => '2025-05-29 08:02:47',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 1,
                'name' => 'Can delete sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:01',
                'updated_at' => '2025-05-29 08:03:01',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 0,
                'name' => 'Role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:26',
                'updated_at' => '2025-05-29 08:03:26',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 5,
                'name' => 'Can add role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:47',
                'updated_at' => '2025-05-29 08:03:47',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 5,
                'name' => 'Can edit role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:02',
                'updated_at' => '2025-05-29 08:04:02',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 5,
                'name' => 'Can delete role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:24',
                'updated_at' => '2025-05-29 08:04:24',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 5,
                'name' => 'Can show role permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:43',
                'updated_at' => '2025-05-29 08:04:43',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 5,
                'name' => 'Can add role permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:53',
                'updated_at' => '2025-05-29 08:04:53',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'name' => 'Permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:04',
                'updated_at' => '2025-05-29 08:05:04',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 11,
                'name' => 'Can add permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:16',
                'updated_at' => '2025-05-29 08:05:16',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 11,
                'name' => 'Can edit permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:28',
                'updated_at' => '2025-05-29 08:05:28',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 11,
                'name' => 'Can delete permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:41',
                'updated_at' => '2025-05-29 08:05:41',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'name' => 'User',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:55',
                'updated_at' => '2025-05-29 08:05:55',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 15,
                'name' => 'Can add user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:06',
                'updated_at' => '2025-05-29 08:06:06',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 15,
                'name' => 'Can show user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:16',
                'updated_at' => '2025-05-29 08:06:16',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 15,
                'name' => 'Can edit user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:27',
                'updated_at' => '2025-05-29 08:06:27',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 15,
                'name' => 'Can delete user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:39',
                'updated_at' => '2025-05-29 08:06:39',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 15,
                'name' => 'Can edit user role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:51',
                'updated_at' => '2025-05-29 08:06:51',
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 0,
                'name' => 'About',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:24:08',
                'updated_at' => '2025-05-29 08:24:08',
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 21,
                'name' => 'Can add about',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:24:25',
                'updated_at' => '2025-05-29 08:24:25',
            ),
            22 => 
            array (
                'id' => 23,
                'parent_id' => 21,
                'name' => 'Can edit about',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:24:37',
                'updated_at' => '2025-05-29 08:24:37',
            ),
            23 => 
            array (
                'id' => 24,
                'parent_id' => 21,
                'name' => 'Can delete about',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:24:55',
                'updated_at' => '2025-05-29 08:24:55',
            ),
            24 => 
            array (
                'id' => 25,
                'parent_id' => 0,
                'name' => 'Article',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:25:14',
                'updated_at' => '2025-05-29 08:25:14',
            ),
            25 => 
            array (
                'id' => 26,
                'parent_id' => 25,
                'name' => 'Can add article',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:25:27',
                'updated_at' => '2025-05-29 08:25:27',
            ),
            26 => 
            array (
                'id' => 27,
                'parent_id' => 25,
                'name' => 'Can edit article',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:25:43',
                'updated_at' => '2025-05-29 08:25:43',
            ),
            27 => 
            array (
                'id' => 28,
                'parent_id' => 25,
                'name' => 'Can delete article',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:25:58',
                'updated_at' => '2025-05-29 08:25:58',
            ),
            28 => 
            array (
                'id' => 29,
                'parent_id' => 25,
                'name' => 'Can set article image',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:26:17',
                'updated_at' => '2025-05-29 08:26:17',
            ),
            29 => 
            array (
                'id' => 30,
                'parent_id' => 0,
                'name' => 'Banner',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:30:26',
                'updated_at' => '2025-05-29 08:30:26',
            ),
            30 => 
            array (
                'id' => 31,
                'parent_id' => 30,
                'name' => 'Can add banner',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:30:38',
                'updated_at' => '2025-05-29 08:30:38',
            ),
            31 => 
            array (
                'id' => 32,
                'parent_id' => 30,
                'name' => 'Can edit banner',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:30:52',
                'updated_at' => '2025-05-29 08:30:52',
            ),
            32 => 
            array (
                'id' => 33,
                'parent_id' => 30,
                'name' => 'Can delete banner',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:31:05',
                'updated_at' => '2025-05-29 08:31:05',
            ),
            33 => 
            array (
                'id' => 34,
                'parent_id' => 0,
                'name' => 'Certificate',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:31:14',
                'updated_at' => '2025-05-29 08:31:14',
            ),
            34 => 
            array (
                'id' => 35,
                'parent_id' => 34,
                'name' => 'Can add certificate',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:31:32',
                'updated_at' => '2025-05-29 08:31:32',
            ),
            35 => 
            array (
                'id' => 36,
                'parent_id' => 34,
                'name' => 'Can edit certificate',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:31:45',
                'updated_at' => '2025-05-29 08:31:45',
            ),
            36 => 
            array (
                'id' => 37,
                'parent_id' => 34,
                'name' => 'Can delete certificate',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:32:01',
                'updated_at' => '2025-05-29 08:32:01',
            ),
            37 => 
            array (
                'id' => 38,
                'parent_id' => 0,
                'name' => 'Partner',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:36:41',
                'updated_at' => '2025-05-30 01:36:41',
            ),
            38 => 
            array (
                'id' => 39,
                'parent_id' => 38,
                'name' => 'Can add partner',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:36:54',
                'updated_at' => '2025-05-30 01:36:54',
            ),
            39 => 
            array (
                'id' => 40,
                'parent_id' => 38,
                'name' => 'Can edit partner',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:37:08',
                'updated_at' => '2025-05-30 01:37:08',
            ),
            40 => 
            array (
                'id' => 41,
                'parent_id' => 38,
                'name' => 'Can delete partner',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:37:23',
                'updated_at' => '2025-05-30 01:37:23',
            ),
            41 => 
            array (
                'id' => 42,
                'parent_id' => 0,
                'name' => 'Customer',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:37:34',
                'updated_at' => '2025-05-30 01:37:34',
            ),
            42 => 
            array (
                'id' => 43,
                'parent_id' => 42,
                'name' => 'Can add customer',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:37:46',
                'updated_at' => '2025-05-30 01:37:46',
            ),
            43 => 
            array (
                'id' => 44,
                'parent_id' => 42,
                'name' => 'Can edit customer',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:37:57',
                'updated_at' => '2025-05-30 01:37:57',
            ),
            44 => 
            array (
                'id' => 45,
                'parent_id' => 42,
                'name' => 'Can delete customer',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:38:12',
                'updated_at' => '2025-05-30 01:38:12',
            ),
            45 => 
            array (
                'id' => 46,
                'parent_id' => 0,
                'name' => 'ExVessel',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:38:24',
                'updated_at' => '2025-05-30 01:38:24',
            ),
            46 => 
            array (
                'id' => 47,
                'parent_id' => 46,
                'name' => 'Can add exvessel',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:38:36',
                'updated_at' => '2025-05-30 01:38:36',
            ),
            47 => 
            array (
                'id' => 48,
                'parent_id' => 46,
                'name' => 'Can edit exvessel',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:38:47',
                'updated_at' => '2025-05-30 01:38:47',
            ),
            48 => 
            array (
                'id' => 49,
                'parent_id' => 46,
                'name' => 'Can delete exvessel',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:39:01',
                'updated_at' => '2025-05-30 01:39:01',
            ),
            49 => 
            array (
                'id' => 50,
                'parent_id' => 46,
                'name' => 'Can set exvessel image',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:39:14',
                'updated_at' => '2025-05-30 01:39:14',
            ),
            50 => 
            array (
                'id' => 51,
                'parent_id' => 0,
                'name' => 'Facility',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:39:22',
                'updated_at' => '2025-05-30 01:39:22',
            ),
            51 => 
            array (
                'id' => 52,
                'parent_id' => 51,
                'name' => 'Can add facility',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:39:33',
                'updated_at' => '2025-05-30 01:39:33',
            ),
            52 => 
            array (
                'id' => 53,
                'parent_id' => 51,
                'name' => 'Can edit facility',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:39:45',
                'updated_at' => '2025-05-30 01:39:45',
            ),
            53 => 
            array (
                'id' => 54,
                'parent_id' => 51,
                'name' => 'Can delete facility',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:01',
                'updated_at' => '2025-05-30 01:40:01',
            ),
            54 => 
            array (
                'id' => 55,
                'parent_id' => 51,
                'name' => 'Can set facility image',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:09',
                'updated_at' => '2025-05-30 01:40:09',
            ),
            55 => 
            array (
                'id' => 56,
                'parent_id' => 0,
                'name' => 'Motto',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:17',
                'updated_at' => '2025-05-30 01:40:17',
            ),
            56 => 
            array (
                'id' => 57,
                'parent_id' => 56,
                'name' => 'Can add motto',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:32',
                'updated_at' => '2025-05-30 01:40:32',
            ),
            57 => 
            array (
                'id' => 58,
                'parent_id' => 56,
                'name' => 'Can edit motto',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:44',
                'updated_at' => '2025-05-30 01:40:44',
            ),
            58 => 
            array (
                'id' => 59,
                'parent_id' => 56,
                'name' => 'Can delete motto',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:40:56',
                'updated_at' => '2025-05-30 01:40:56',
            ),
            59 => 
            array (
                'id' => 60,
                'parent_id' => 0,
                'name' => 'Product Category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:41:10',
                'updated_at' => '2025-05-30 01:41:10',
            ),
            60 => 
            array (
                'id' => 61,
                'parent_id' => 60,
                'name' => 'Can add product category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:41:21',
                'updated_at' => '2025-05-30 01:41:21',
            ),
            61 => 
            array (
                'id' => 62,
                'parent_id' => 60,
                'name' => 'Can edit product category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:41:34',
                'updated_at' => '2025-05-30 01:41:34',
            ),
            62 => 
            array (
                'id' => 63,
                'parent_id' => 60,
                'name' => 'Can delete product category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:41:47',
                'updated_at' => '2025-05-30 01:41:47',
            ),
            63 => 
            array (
                'id' => 64,
                'parent_id' => 0,
                'name' => 'Product',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:41:56',
                'updated_at' => '2025-05-30 01:41:56',
            ),
            64 => 
            array (
                'id' => 65,
                'parent_id' => 64,
                'name' => 'Can add product',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:42:07',
                'updated_at' => '2025-05-30 01:42:07',
            ),
            65 => 
            array (
                'id' => 66,
                'parent_id' => 64,
                'name' => 'Can edit product',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:42:20',
                'updated_at' => '2025-05-30 01:42:20',
            ),
            66 => 
            array (
                'id' => 67,
                'parent_id' => 64,
                'name' => 'Can delete product',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:42:35',
                'updated_at' => '2025-05-30 01:42:35',
            ),
            67 => 
            array (
                'id' => 68,
                'parent_id' => 64,
                'name' => 'Can set product image',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:42:46',
                'updated_at' => '2025-05-30 01:42:46',
            ),
            68 => 
            array (
                'id' => 69,
                'parent_id' => 0,
                'name' => 'Project Category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:43:07',
                'updated_at' => '2025-05-30 01:43:07',
            ),
            69 => 
            array (
                'id' => 70,
                'parent_id' => 69,
                'name' => 'Can add project category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:43:19',
                'updated_at' => '2025-05-30 01:43:19',
            ),
            70 => 
            array (
                'id' => 71,
                'parent_id' => 69,
                'name' => 'Can edit project category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:43:30',
                'updated_at' => '2025-05-30 01:43:30',
            ),
            71 => 
            array (
                'id' => 72,
                'parent_id' => 69,
                'name' => 'Can delete project category',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:43:46',
                'updated_at' => '2025-05-30 01:43:46',
            ),
            72 => 
            array (
                'id' => 73,
                'parent_id' => 0,
                'name' => 'Project',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:50:17',
                'updated_at' => '2025-05-30 01:50:17',
            ),
            73 => 
            array (
                'id' => 74,
                'parent_id' => 73,
                'name' => 'Can add project',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:50:30',
                'updated_at' => '2025-05-30 01:50:30',
            ),
            74 => 
            array (
                'id' => 75,
                'parent_id' => 73,
                'name' => 'Can edit project',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:50:42',
                'updated_at' => '2025-05-30 01:50:42',
            ),
            75 => 
            array (
                'id' => 76,
                'parent_id' => 73,
                'name' => 'Can delete project',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:51:00',
                'updated_at' => '2025-05-30 01:51:00',
            ),
            76 => 
            array (
                'id' => 77,
                'parent_id' => 73,
                'name' => 'Can set project image',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:51:14',
                'updated_at' => '2025-05-30 01:51:14',
            ),
            77 => 
            array (
                'id' => 78,
                'parent_id' => 0,
                'name' => 'Client',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:51:36',
                'updated_at' => '2025-05-30 01:51:36',
            ),
            78 => 
            array (
                'id' => 79,
                'parent_id' => 78,
                'name' => 'Can add client',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:51:48',
                'updated_at' => '2025-05-30 01:51:48',
            ),
            79 => 
            array (
                'id' => 80,
                'parent_id' => 78,
                'name' => 'Can edit client',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:51:59',
                'updated_at' => '2025-05-30 01:51:59',
            ),
            80 => 
            array (
                'id' => 81,
                'parent_id' => 78,
                'name' => 'Can delete client',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:52:11',
                'updated_at' => '2025-05-30 01:52:11',
            ),
            81 => 
            array (
                'id' => 82,
                'parent_id' => 0,
                'name' => 'Vision',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:52:21',
                'updated_at' => '2025-05-30 01:52:21',
            ),
            82 => 
            array (
                'id' => 83,
                'parent_id' => 82,
                'name' => 'Can add vision',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:52:32',
                'updated_at' => '2025-05-30 01:52:32',
            ),
            83 => 
            array (
                'id' => 84,
                'parent_id' => 82,
                'name' => 'Can edit vision',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:52:44',
                'updated_at' => '2025-05-30 01:52:44',
            ),
            84 => 
            array (
                'id' => 85,
                'parent_id' => 82,
                'name' => 'Can delete vision',
                'guard_name' => 'web',
                'created_at' => '2025-05-30 01:52:55',
                'updated_at' => '2025-05-30 01:52:55',
            ),
        ));
        
        
    }
}