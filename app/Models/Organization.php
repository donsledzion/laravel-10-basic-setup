<?php

namespace App\Models;

use App\Enums\OrganizationRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\UserRoles;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefix',
        'expires_at',
        'headset_login',
        'headset_pin',
        'logo',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function managers():belongsToMany
    {
        //return users()->where('role',UserRoles::MANAGER)->get();
        return $this->belongsToMany(User::class)->wherePivot('role',OrganizationRoles::MANAGER->value);

        return Organization::whereHas('users',function($query){
            return $query->where('role', UserRoles::MANAGER);
        })->get();
    }

    public function scenarios():HasMany
    {
        return $this->hasMany(Scenario::class);
    }
}
