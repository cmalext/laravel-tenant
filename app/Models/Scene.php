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

        // move this into a new scope 
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
