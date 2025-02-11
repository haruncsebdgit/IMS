<?php

namespace App\Console\Commands;

use Cache;
use App\Models\RolePermission;
use App\Models\Settings\Option;
use Illuminate\Console\Command;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup-application';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the Application up for further proceedings';

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
        $subscriber_caps = array('view_dashboard');

        $serializedCaps = Option::maybeSerialize($subscriber_caps);

        $subscriber = RolePermission::where('slug', 'subscriber')->first();

        if (!$subscriber) {
            RolePermission::create([
                'name'        => 'Subscriber',
                'name_bn'     => 'সাবস্ক্রাইবার',
                'slug'        => 'subscriber',
                'permissions' => $serializedCaps
            ]);

            $this->info('Subscriber role was created with all the capabilities');
        } else {
            RolePermission::where('slug', 'subscriber')
                ->update([
                    'permissions' => $serializedCaps
                ]);

            // Clear the subscriber role cache.
            if (Cache::has('user_role_subscriber')) {
                Cache::forget('user_role_subscriber');
            }

            $this->info('Subscriber role was updated with all the capabilities');
        }
    }
}
