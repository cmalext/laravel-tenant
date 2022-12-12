<?php

namespace App\Providers;

use App\Actions\Tenants\TenantDetector;
use App\Models\Tenant;
use App\Services\Tenants\TenantSettingsService;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Detects the tenant and registers tenant services.
     *
     * @return void
     */
    public function boot()
    {
        $tenant = (new TenantDetector)->detect();
        
        self::loadTenant($tenant);
    }

    /**
     * Force a tenant to be loaded. useful for getting the correct tenant config 
     * when running the app via console
     *
     * @param string $code
     * 
     * @return void
     */
    public static function forceTenant($code)
    {
        app()->forgetInstance('ts');

        $tenant = Tenant::where('code', $code)->first();

        if ($tenant) self::loadTenant($tenant);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Load tenant
     * 
     * @param Tenant|object $tenant
     * 
     * @return void
     */
    protected function loadTenant($tenant)
    {
        // load TenantSettingsService::class as ts
        app()->singleton('ts', function ($app) use ($tenant) {
            return new TenantSettingsService($tenant);
        });

        // load the tenant config
        $tenantConfig = config('tenants.' . $tenant->code, []);
        $mergedConfig = array_replace_recursive(config()->all(), $tenantConfig);
        config($mergedConfig);

        // share tenant data to the views
        view()->share('tid', $tenant->id);
        view()->share('tcode', $tenant->code);
        view()->share('tname', $tenant->name);
    }
}
