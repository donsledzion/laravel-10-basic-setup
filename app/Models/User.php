<?php

namespace App\Models;

use App\Enums\UserRoles;
use App\Enums\OrganizationRoles;
use App\Models\Organization;
use App\Models\Scenario;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRoles::class
    ];

    public function isAdmin():bool
    {
        return $this->role == UserRoles::ADMIN;
    }

    public function isUser():bool
    {
        return $this->role == UserRoles::USER;
    }

    public function organizations():BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->withPivot('role');
    }

    public function scenarios():HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    public function organizationRole(Organization $organization)
    {
        if($this->organizations->count() < 1) return null;
        return $this->organizations()->where('id',$organization->id)->firstOrFail()->pivot->role;        
    }

    public function canCreateScenariosForOrganization(Organization $organization):bool 
    {
        if($this->organizationRole($organization) == OrganizationRoles::MANAGER ||
        $this->organizationRole($organization) == OrganizationRoles::TRAINER)
            return true;
        return false;
    }

    public function isOrganizationAdmin(Organization $organization){
        return $this->organizationRole($organization) == OrganizationRoles::ADMIN->value;
    }

    public function isOrganizationManager(Organization $organization){
        return $this->organizationRole($organization) == OrganizationRoles::MANAGER->value;
    }

    public function isOrganizationTrainer(Organization $organization){
        return $this->organizationRole($organization) == OrganizationRoles::TRAINER->value;
    }

    public function canEditOrganization(Organization $organization){
        return ($this->isAdmin() || (
                $this->isOrganizationManager($organization)|| (
                $this->isORganizationAdmin($organization))));
    }

}
