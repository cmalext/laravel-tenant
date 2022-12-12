<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    /**
     * Anonymous scope
     */
    protected static function boot()
    {
        parent::boot();

        // move this into a new scope 
        if (!app()->runningInConsole()) {
            static::addGlobalScope('ChannelTenantScope', function (Builder $builder) {
                $builder->where('tenant_id', (resolve('ts'))->tenant()->id);
            });
        }
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'id', 'tenant_id');
    }

    public function getThumbnailAttribute()
    {
        return 'https://via.placeholder.com/600x300/333?text=' . $this->attributes['name'];

        // uniform the thumbnails or create a new field on the table
        return sprintf('%s/thumbnails/%s.jpg', config('app.assets_url'), $this->attributes['code']);
    }
}
