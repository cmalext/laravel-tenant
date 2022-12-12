<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    /**
     * Anonymous scope
     */
    protected static function boot()
    {
        parent::boot();

        // Tenant scope. Move this a scope
        if (!app()->runningInConsole()) {
            static::addGlobalScope('SceneTenantScope', function (Builder $builder) {
                $channelIds = resolve('ts')->channelIds();
                $builder->whereIn('channel_id', $channelIds);
            });
        }
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }
}
