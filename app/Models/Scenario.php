<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Scenario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'pin',
        'logo',
        'color_question_text',
        'color_answer_text',
        'color_question_background',
        'color_answer_background',
        'color_floor',
        'interaction_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function quizzes():HasMany
    {
        return $this->HasMany(Quiz::class);
    }

    public function organization():BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function interaction():BelongsTo
    {
        return $this->belongsTo(AnsweringInteractionType::class,'interaction_id','id');
    }


    public function getLogoFile(string $logo = null)
    {
        try{
            if($logo == null){
                if($this->logo == null || empty($this->logo)) return null;
                $logoPath = 'multimedia/'.$this->organization->id.'/pictures/'.$this->logo;
            } else {
                $logoPath = 'multimedia/'.$this->organization->id.'/pictures/'.$logo;
            }
            if($logoPath != null && Storage::exists($logoPath)){
                return $logoPath;
            }

            return null;
        } catch(\Exception $e){
            $msg = "An error occurred while trying to get scenario ".$this->name." logo file. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }

    public function getLogoFileFullPath()
    {
        if($this->logo == null || empty($this->logo)){
            if($this->organization->logo == null || empty($this->organization->logo))
            return '';
            return $this->organization->getLogoFullPath();
        }
        if(!asset('organizations'.'/'.$this->organization->id.'/pictures/'.$this->logo)) return '';
        return asset('organizations'.'/'.$this->organization->id.'/pictures/'.$this->logo);
    }

    public function removeLogoFile(string $logo = null)
    {
        try{
            if($logo == null){
                $logo = $this->getLogoFile();
                if($logo == null) return;
            } else {
                $logo = $this->getLogoFile($logo);
                error_log("Found logo at: ".$logo);
            }
            if($logo != null && Storage::exists($logo))
                Storage::delete($logo);
        } catch(\Exception $e){
            $msg = "An error occurred while trying to remove organization ".$this->name." logo file. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }
}
