<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        return $this->belongsToMany(User::class)->withPivot('role_id');
    }

    public function managers():BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('role_id',Role::firstWhere('name', 'manager'));
    }

    public function admin():User | null
    {
        return $this->users()
            ->wherePivot('role_id',Role::firstWhere('name', 'admin')->id)->first();
    }

    public function scenarios():HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    public function tokens():HasMany
    {
        return $this->hasMany(OrganizationToken::class);
    }

    public function logoFile():HasOne
    {
        return $this->hasOne(MediaFile::class,'id','logo');
    }

    public function getLogoFile(string $logo = null)
    {
        try{
            if($logo == null){
                if($this->logo == null || empty($this->logo)) return null;
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


    public function getLogoFullPath(): string
    {
        if($this->logo == null || empty($this->logo)) return '';
        if(!asset('organizations'.'/'.$this->id.'/pictures/'.$this->logo)) return '';
        return asset('organizations'.'/'.$this->id.'/pictures/'.$this->logo);
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
            if(Storage::exists($logo))
                Storage::delete($logo);
        } catch(\Exception $e){
            $msg = "An error occurred while trying to remove organization ".$this->name." logo file. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }

    public function removeMember(User $user)
    {
        if($this->admin() != null && $this->admin() != $user){
            $this->moveScenariosToAdmin($user);
        }
        $this->users()->detach($user);
        if($user->organizations->count() < 1){
            $user->delete();
        }
    }

    private function moveScenariosToAdmin(User $user)
    {
        if($user->scenarios()->where('organization_id',$this->id)->count() > 0){
            $user->scenarios()
            ->where('organization_id',$this->id)
            ->get()
            ->toQuery()
            ->update([
                'user_id' => $this->admin()->id
            ]);
        }

    }
}
