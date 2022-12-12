<?php

namespace App\Actions\Tenants;

use App\Models\Channel;
use App\Models\Tenant;
use Exception;

class TenantDetector
{
    /**
     * Detects the tenant by http host
     *
     * @return Tenant
     */
    public function detect()
    {
        try {
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

            // check if there is a channel with the domain
            $channel = Channel::where('domain', $host)->first();

            if ($channel) return $channel->tenant;

            return $tenants[0];
        } catch (Exception $e) {
            // no migration yet or a database connection issue
            return $this->defaultTenant();
        }
    }

    /**
     * Default tenant
     * 
     * @return object
     */
    public function defaultTenant()
    {
        return (object) [
            'id'    => 0,
            'code'  => 'default',
            'name'  => 'Default Tenant',
        ];
    }
}
