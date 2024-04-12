<?php

namespace App\Models;

use App\Enums\OrganizationRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function managers():BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('role',OrganizationRoles::MANAGER->value);
    }

    public function admin():User | null
    {
        return $this->users()
                    ->wherePivot('role',OrganizationRoles::ADMIN->value)->first();
    }

    public function scenarios():HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    public function tokens():HasMany
    {
        return $this->hasMany(OrganizationToken::class);
    }

    public function getLogoFile(string $logo = null)
    {
        try{
            if($logo == null){
                if($this->logo == null || Str::emtpy($this->logo)) return null;
                $logoPath = 'multimedia/'.$this->id.'/pictures/'.$this->logo;                                
            } else {
                $logoPath = 'multimedia/'.$this->id.'/pictures/'.$logo;
            }
            if(Storage::exists($logoPath)){
                return $logoPath;
            }
            
            return null;
        } catch(\Exception $e){
            $msg = "An error occurred while trying to get organization ".$this->name." logo file. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
        
    }

    public function removeLogoFile(string $logo = null)
    {
        try{
            if($logo == null){
                $logo = $this->getLogoFile();
                if($logo == null) return;
            } else {
                $logo = $this->getLogoFile($logo);
            }
            Storage::delete($logo);
        } catch(\Exception $e){
            $msg = "An error occurred while trying to remove organization ".$this->name." logo file. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }
}
