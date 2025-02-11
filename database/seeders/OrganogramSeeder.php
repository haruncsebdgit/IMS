<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class OrganogramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Inserting fixed parent
        DB::table('organograms')->insert([
            'id' => 1,
            'parent_id' => 0,
            'name_en' => 'Government of the People’s Republic of Bangladesh',
            'name_bn' => 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার',
            'office_type' => $faker->randomDigit,
            'division_region_id' => $faker->randomDigit,
            'district_id' => null,
            'upazila_id' => null,
            'code' => $faker->buildingNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'fax' => $faker->phoneNumber,
            'is_active' => 1,
            'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
            'created_by' => $faker->randomDigit,
            'created_at' => $faker->dateTime,
        ]);

        DB::table('organograms')->insert([
            'id' => 2,
            'parent_id' => 1,
            'name_en' => 'PMU',
            'name_bn' => 'PMU',
            'office_type' => $faker->randomDigit,
            'division_region_id' => $faker->randomDigit,
            'district_id' => null,
            'upazila_id' => null,
            'code' => $faker->buildingNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'fax' => $faker->phoneNumber,
            'is_active' => 1,
            'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
            'created_by' => $faker->randomDigit,
            'created_at' => $faker->dateTime,
        ]);

        DB::table('organograms')->insert([
            'id' => 3,
            'parent_id' => 2,
            'name_en' => 'PIU (DOF/DLS/DAE)',
            'name_bn' => 'PIU (DOF/DLS/DAE)',
            'office_type' => $faker->randomDigit,
            'division_region_id' => $faker->randomDigit,
            'district_id' => null,
            'upazila_id' => null,
            'code' => $faker->buildingNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'fax' => $faker->phoneNumber,
            'is_active' => 1,
            'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
            'created_by' => $faker->randomDigit,
            'created_at' => $faker->dateTime,
        ]);

        DB::table('organograms')->insert([
            'id' => 4,
            'parent_id' => 3,
            'name_en' => 'Division/Region Office',
            'name_bn' => 'Division/Region Office',
            'office_type' => $faker->randomDigit,
            'division_region_id' => $faker->randomDigit,
            'district_id' => null,
            'upazila_id' => null,
            'code' => $faker->buildingNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'fax' => $faker->phoneNumber,
            'is_active' => 1,
            'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
            'created_by' => $faker->randomDigit,
            'created_at' => $faker->dateTime,
        ]);

        DB::table('organograms')->insert([
            'id' => 5,
            'parent_id' => 4,
            'name_en' => 'District Office 1',
            'name_bn' => 'District Office 1',
            'office_type' => $faker->randomDigit,
            'division_region_id' => $faker->randomDigit,
            'district_id' => 1,
            'upazila_id' => null,
            'code' => $faker->buildingNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'fax' => $faker->phoneNumber,
            'is_active' => 1,
            'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
            'created_by' => $faker->randomDigit,
            'created_at' => $faker->dateTime,
        ]);

        // Adding child element
       
        for($i = 6; $i <= 15; $i++){
            DB::table('organograms')->insert([
                'id' => $i,
                'parent_id' => 4,
                'name_en' => 'District Office ' . $i,
                'name_bn' => 'District Office ' . $i,
                'office_type' => $faker->randomDigit,
                'division_region_id' => $faker->randomDigit,
                'district_id' => 1,
                'upazila_id' => 11006,
                'code' => $faker->buildingNumber,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'fax' => $faker->phoneNumber,
                'is_active' => 1,
                'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
                'created_by' => $faker->randomDigit,
                'created_at' => $faker->dateTime,
            ]);
        }

        for($i = 16; $i <= 24; $i++){
            DB::table('organograms')->insert([
                'id' => $i,
                'parent_id' => 5,
                'name_en' => 'Upazila Office ' . $i,
                'name_bn' => 'Upazila Office ' . $i,
                'office_type' => $faker->randomDigit,
                'division_region_id' => $faker->randomDigit,
                'district_id' => 1,
                'upazila_id' => 11006,
                'code' => $faker->buildingNumber,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'fax' => $faker->phoneNumber,
                'is_active' => 1,
                'is_inventory_center' => $faker->numberBetween ($min = 0, $max = 1),
                'created_by' => $faker->randomDigit,
                'created_at' => $faker->dateTime,
            ]);
        }
    }
}
