<?php

use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;


class DefaultNotificationSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationSetting::create([
            'name' => "SMS"
        ]);
        NotificationSetting::create([
            'name' => "Email"
        ]);
    }
}
