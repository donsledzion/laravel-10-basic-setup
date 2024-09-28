<?php

namespace App\Models;

use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
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

    public static function validatePath(string $path)
    {
        if(!File::exists($path)) {
            File::makeDirectory($path, 0775, true, true);
        }
    }

    public static function create($attributes)
    {
        try{
            $file = $attributes["file"];
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $basePath = 'multimedia/';
            if(array_key_exists("organization",$attributes)){
                $basePath .=$attributes["organization"].'/'.self::extension2mediaType($ext).'s/';
            } else{
                $basePath .='multimedia/internal/'.self::extension2mediaType($ext).'s/';
            }
            self::validatePath($basePath);
            $file->storeAs($basePath, $hashName);

            $newMediaFile = new MediaFile(['name' => $hashName, 'type' => self::extension2mediaType($ext)]);
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
        $organization = "internal";
        if($this->organization != null)
            $organization = $this->organization->id;
        return config('app.url').'/organizations/'.$organization.'/'.$this->directory().'/'.$this->name;
    }

    public function directory():string
    {
        return $this->type->value.'s';
    }

    public static function extension2mediaType(string $ext):string
    {
        $pictureExtensions = array('png', 'jpg', 'jpeg', 'bmp', 'gif');
        $audioExtensions = array('mp3', 'wav', 'ogg');
        $videoExtensions = array('mp4', 'mkv', 'mov');

        foreach ($pictureExtensions as $extension)
        {
            if($extension == $ext) return 'picture';
        }
        foreach ($audioExtensions as $extension)
        {
            if($extension == $ext) return 'audio';
        }
        foreach ($videoExtensions as $extension)
        {
            if($extension == $ext) return 'video';
        }
        return 'other';
    }

    public function organization():belongsTo
    {
        return $this->belongsTo(Organization::class,'logo','id');
    }
}
