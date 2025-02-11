<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommonLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Data Type 'education-degrees'.
            [
                'id'         => 1,
                'data_type'  => 'education-degrees',
                'name_en'    => 'Masters',
                'name_bn'    => 'মাস্টার্স',
                'organization_id' => null,
                'is_delatable'    => 1,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 2,
                'data_type'  => 'education-degrees',
                'name_en'    => 'Honors',
                'name_bn'    => 'অনার্স',
                'organization_id' => null,
                'is_delatable'    => 1,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],

            // Data Type 'countries'.
            [
                'id'         => 3,
                'data_type'  => 'countries',
                'name_en'    => 'Bangladesh',
                'name_bn'    => 'বাংলাদেশ',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 4,
                'data_type'  => 'countries',
                'name_en'    => 'India',
                'name_bn'    => 'ভারত',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],

            // User Designations => designations
            [
                'id'         => 5,
                'data_type'  => 'designations',
                'name_en'    => 'DoF',
                'name_bn'    => 'DoF',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactiv
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 6,
                'data_type'  => 'designations',
                'name_en'    => 'DLS',
                'name_bn'    => 'DLS',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 0,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 7,
                'data_type'  => 'cig-designation',
                'name_en'    => 'CIG Leader',
                'name_bn'    => 'CIG Leader',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 8,
                'data_type'  => 'cig-designation',
                'name_en'    => 'General Member',
                'name_bn'    => 'General Member',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 9,
                'data_type'  => 'cig-designation',
                'name_en'    => 'EC Member',
                'name_bn'    => 'EC Member',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 10,
                'data_type'  => 'trainee-type',
                'name_en'    => 'CIG',
                'name_bn'    => 'CIG',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 11,
                'data_type'  => 'trainee-type',
                'name_en'    => 'CIG Leader',
                'name_bn'    => 'CIG Leader',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 12,
                'data_type'  => 'trainee-type',
                'name_en'    => 'Nursery Operator',
                'name_bn'    => 'Nursery Operator',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 13,
                'data_type'  => 'trainee-type',
                'name_en'    => 'Hatchery Operator',
                'name_bn'    => 'Hatchery Operator',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 14,
                'data_type'  => 'trainee-type',
                'name_en'    => 'LEAF',
                'name_bn'    => 'LEAF',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 15,
                'data_type'  => 'trainee-type',
                'name_en'    => 'CEAL',
                'name_bn'    => 'CEAL',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 16,
                'data_type'  => 'trainee-type',
                'name_en'    => 'SAAO',
                'name_bn'    => 'SAAO',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 17,
                'data_type'  => 'trainer-type',
                'name_en'    => 'LEAF',
                'name_bn'    => 'LEAF',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 18,
                'data_type'  => 'trainer-type',
                'name_en'    => 'CEAL',
                'name_bn'    => 'CEAL',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
             [
                'id'         => 19,
                'data_type'  => 'trainer-type',
                'name_en'    => 'SAAO',
                'name_bn'    => 'SAAO',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 20,
                'data_type'  => 'trainer-type',
                'name_en'    => 'Officer',
                'name_bn'    => 'Officer',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 21,
                'data_type'  => 'trainer-type',
                'name_en'    => 'Staff',
                'name_bn'    => 'Staff',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 22,
                'data_type'  => 'trainer-type',
                'name_en'    => 'Outside Trainer',
                'name_bn'    => 'Outside Trainer',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 23,
                'data_type'  => 'employee-type',
                'name_en'    => 'Officer ',
                'name_bn'    => 'Officer',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 24,
                'data_type'  => 'employee-type',
                'name_en'    => 'Staff',
                'name_bn'    => 'Staff',
                'is_delatable'    => 0,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 25,
                'data_type'  => 'po-income-head',
                'name_en'    => 'Crate Rent',
                'name_bn'    => 'Crate Rent',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 26,
                'data_type'  => 'po-income-head',
                'name_en'    => 'Van Rent',
                'name_bn'    => 'রিক্সা ভ্যান',
                'is_delatable'    => 1,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 27,
                'data_type'  => 'po-income-head',
                'name_en'    => 'Beneficiary Businessman',
                'name_bn'    => 'Beneficiary Businessman',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 3,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 28,
                'data_type'  => 'po-income-head',
                'name_en'    => 'Others',
                'name_bn'    => 'Others',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 4,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],


            [
                'id'         => 29,
                'data_type'  => 'po-trader-type',
                'name_en'    => 'Whole',
                'name_bn'    => 'Whole',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 30,
                'data_type'  => 'po-trader-type',
                'name_en'    => 'Retailer',
                'name_bn'    => 'Retailer',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 31,
                'data_type'  => 'po-trader-type',
                'name_en'    => 'Arotdar',
                'name_bn'    => 'Arotdar',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 3,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 32,
                'data_type'  => 'po-trader-type',
                'name_en'    => 'Others',
                'name_bn'    => 'Others',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 4,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 33,
                'data_type'  => 'po-delivery-mode',
                'name_en'    => 'Sent by Seller',
                'name_bn'    => 'Sent by Seller',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 34,
                'data_type'  => 'po-delivery-mode',
                'name_en'    => 'Home Delivery',
                'name_bn'    => 'Home Delivery',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 35,
                'data_type'  => 'po-delivery-mode',
                'name_en'    => 'Parcel',
                'name_bn'    => 'Parcel',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 3,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],

            [
                'id'         => 36,
                'data_type'  => 'establish-phase',
                'name_en'    => 'NATP1',
                'name_bn'    => 'NATP1',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 37,
                'data_type'  => 'establish-phase',
                'name_en'    => 'NATP2',
                'name_bn'    => 'NATP2',
                'is_delatable' => 1,
                'organization_id' => null,
                'order'      => 2,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'id'         => 38,
                'data_type'  => 'cig-category-dls',
                'name_en'    => 'Cow Rearing',
                'name_bn'    => 'Cow Rearing',
                'is_delatable' => 1,
                'organization_id' => config('app.organization_id_dls'),
                'order'      => 1,
                'status'     => 1, // must be tinyint(1) . 1 for active and 0 for inactive
                'code'       => null,
                'created_by' => 1,
                'updated_by' => 1
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('common_labels')->truncate();
        foreach ($data as $value) {
            DB::table('common_labels')->updateOrInsert(
                [
                    'id'         => $value['id'],
                    'data_type'  => $value['data_type'],
                    'name_en'    => $value['name_en'],
                    'name_bn'    => $value['name_bn'],
                    'is_delatable'    => $value['is_delatable'],
                    'organization_id'    => $value['organization_id'],
                    'order'      => $value['order'],
                    'status'     => $value['status'],
                    'code'       => $value['code'],
                    'created_by' => $value['created_by'],
                    'updated_by' => $value['updated_by'],
                ]
            );
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
