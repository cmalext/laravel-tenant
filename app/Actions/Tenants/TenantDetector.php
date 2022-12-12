<?php

namespace App\Actions\Tenants;

use App\Models\Series;
use App\Models\Tenant;
use Exception;

class TenantDetector
{
    /**
     * Detects the tenant from http host
     *
     * @return Tenant
     */
    public function detect()
    {
        $host = request()->getHttpHost();

        // put cache here
        $tenants = Tenant::all();

        if ($tenants->isEmpty()) {
            return $this->defaultTenant();
        }

        // put cache here
        foreach ($tenants as $tenant) {
            $domains = config('tenants.' . $tenant->code . '.app.domains', []);

            if (in_array($host, $domains)) {
                return $tenant;
            }
        }

        try {
            return Series::where('domain', $host)->first()->tenant;
        } catch (Exception $e) {
        }

        return $tenants[0];
    }

    public function defaultTenant()
    {
        return (object) [
            'id'    => 0,
            'code'  => 'default',
            'name'  => 'Default Tenant',
        ];
    }
}
