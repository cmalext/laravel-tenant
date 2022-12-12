<?php

namespace App\Services\Tenants;

use App\Models\Tenant;

class TenantSettingsService
{
    /**
     * @var Tenant|object $tenant
     */
    protected $tenant;

    /**
     * Service constructor
     * 
     * @param Tenant|object $tenant
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Return the object representation of tenant
     * 
     * @return object
     */
    public function tenant()
    {
        return $this->tenant instanceof Tenant ? (object) $this->tenant->toArray() : $this->tenant;
    }

    /**
     * Return channels of a tenant
     * 
     * @return mixed
     */
    public function channels()
    {
        if (!$this->tenant instanceof Tenant) return [];

        return $this->tenant->channels;
    }

    /**
     * Return channels of a tenant
     * 
     * @return array
     */
    public function channelIds()
    {
        if (!$this->tenant instanceof Tenant) return [];

        return $this->tenant->channels->pluck('id')->toArray();
    }
}
