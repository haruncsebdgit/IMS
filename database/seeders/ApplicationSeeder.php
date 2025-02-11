<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder for Entering Settings specific to the Application.
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // [
            //     // Registration Open? No.
            //     'option_name'  => 'is_register_open',
            //     'option_value' => 0,
            // ],
            [
                // Used for Shongjukti Attachments and Documents.
                'option_name'  => 'attachments_max_file_size',
                'option_value' => 5000000,
            ],
            [
                // Used for Shongjukti Attachments and Documents.
                'option_name'  => 'attachments_file_types',
                'option_value' => 'jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx',
            ],
            [
                'option_name'  => 'facebook',
                'option_value' => '',
            ],
            [
                'option_name'  => 'twitter',
                'option_value' => '',
            ],
            [
                'option_name'  => 'linkedin',
                'option_value' => '',
            ],
        ];

        // DB::table('options')->truncate();

        foreach ($data as $value) {
            DB::table('options')->updateOrInsert(
                [
                    'option_name' =>  $value['option_name'],
                    'option_value' => $value['option_value'],
                ]
            );
        }
    }
}
