<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class TrainingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('training_categories')->insert([
            'id' => 1,
            'parent_id' => 0,
            'name_en' => 'Training Category',
            'name_bn' => 'ট্রেনিং ক্যাটাগরি',
            'organization_id' =>null,
            'is_parent_category' => 1,
            'code' => 1,
            'is_active' => 1,
            'created_by' => 1,
            'created_at' => $faker->dateTime,
        ]);
    }
}
