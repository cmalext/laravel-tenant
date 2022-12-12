<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Channel;
use App\Models\Scene;
use App\Models\Tenant;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::all();

        if ($tenants->isEmpty()) {
            Artisan::call('tenant:create', [
                '--name'    => 'Youtube',
                '--code'    => 'yt',
                '--domain'  => 'localhost:8000'
            ]);

            Artisan::call('tenant:create', [
                '--name'    => 'Facebook',
                '--code'    => 'fb',
                '--domain'  => '127.0.0.1:8000'
            ]);

            $tenants = Tenant::all();
        }

        foreach ($tenants as $tenant) {
            if (User::where('tenant_id', $tenant->id)->count() == 0) {
                User::factory()->create([
                    'tenant_id' => $tenant->id,
                ]);
            }

            if (Channel::where('tenant_id', $tenant->id)->count() == 0) {
                $channelCount = 5;

                for ($i = 0; $i <= $channelCount; $i++) {
                    Channel::factory()->create([
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }

            $channelIds = Channel::pluck('id')->toArray();

            foreach ($channelIds as $channelId) {
                if (Scene::where('channel_id', $channelId)->count() == 0) {
                    Scene::create([
                        'title'         => fake()->sentence(),
                        'description'   => fake()->paragraph(),
                        'thumbnail'     => fake()->imageUrl(),
                        'channel_id'    => $channelId
                    ]);
                }
            }
        }
    }
}
