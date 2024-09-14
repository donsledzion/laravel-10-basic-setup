<?php

namespace App\Models;

use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];

    protected $casts = [
        'type' => MediaTypes::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function create($attributes)
    {
        try{
            $file = $attributes["file"];
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $file->storeAs('multimedia/'.$attributes["organization"].'/pictures/', $hashName);
            $newMediaFile = new MediaFile(['name' => $hashName]);
            $newMediaFile->save();
            return $newMediaFile;
        } catch(\Exception $e){
            $msg = "Failed to store media file! ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return null;
        }
    }

    public function getMediaPath():string
    {
        return 'multimedia/'.$this->organization->id.'/'.$this->directory().'/'.$this->name;
    }

    public function directory():string
    {
        switch ($this->type){
            case MediaTypes::AUDIO->value:
                return 'audios';
            case MediaTypes::VIDEO->value:
                return 'videos';
            default:
                return 'pictures';
        }
    }

    public function organization():belongsTo
    {
        return $this->belongsTo(Organization::class,'logo','id');
    }
}
