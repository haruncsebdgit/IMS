<?php

namespace App\Console\Commands;

use Cache;
use App\Models\RolePermission;
use App\Models\Settings\Option;
use Illuminate\Console\Command;
use App\Http\Controllers\Users\UserController;

class SetAdminPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setadminpermissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will set the base permissions for the role: Administrator';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allCaps = UserController::capabilities();

        $serializedCaps = Option::maybeSerialize($allCaps);

        $admin = RolePermission::where('slug', 'administrator')->first();
        if( ! $admin ) {
            RolePermission::create([
                'name'        => 'Administrator',
                'name_bn'     => 'প্রশাসক',
                'slug'        => 'administrator',
                'permissions' => $serializedCaps
            ]);
            $this->info('Administrator role was created with all the capabilities');
        } else {
            RolePermission::where('slug', 'administrator')
            ->update([
                'permissions' => $serializedCaps
            ]);

            // Clear the administrator role cache.
            if (Cache::has('user_role_administrator')) {
                Cache::forget('user_role_administrator');
            }

            $this->info('Administrator role was updated with all the capabilities');
        }
    }
}
