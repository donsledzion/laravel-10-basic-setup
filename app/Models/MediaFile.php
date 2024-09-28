<?php

namespace App\Models;

use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function organization():hasOne
    {
        return $this->hasOne(Organization::class,'logo','id');
    }

    public static function validatePath(string $path):bool
    {
        try {
            Log::debug("About to validate directory: " . $path);
            if (!Storage::exists($path)) {
                Log::debug("Directory does not exists yet: " . $path);
                File::makeDirectory($path, 0777, true, true);
                Log::debug("Created directory: " . $path);
            } else {
                Log::debug("Directory already exists: " . $path);
            }
            return true;
        } catch (\Exception $e) {
            Log::debug("Something went wrong while trying to validate path: " . $path);
            return false;
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
                $basePath .='internal/'.self::extension2mediaType($ext).'s/';
            }
            if(self::validatePath($basePath))
                $file->storeAs($basePath, $hashName);
            else
                throw new \Exception("Something went wrong while trygin to create new Media File!");
            Storage::setVisibility($basePath.'/'.$hashName,'public');

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
}
