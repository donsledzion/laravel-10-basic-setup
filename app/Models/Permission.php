<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function can(string $permissionName):bool
    {
        return $this->roles->where('name',$permissionName)->first() != null;
    }
}
