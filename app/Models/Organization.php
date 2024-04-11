<?php

namespace App\Models;

use App\Enums\OrganizationRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function managers():belongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('role',OrganizationRoles::MANAGER->value);
    }

    public function scenarios():Collection
    {
        $scenarios = new Collection();
        foreach($this->users as $user){
            $scenarios->push($user->scenarios);
        }
        return $scenarios;
        //return $this->hasMany(Scenario::class);
    }

    public function tokens():HasMany
    {
        return $this->hasMany(OrganizationToken::class);
    }
}
