<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuizTypes;
use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'question_text',
        'question_picture',
        'question_audio'
    ];

    protected $casts = [
        'type' => QuizTypes::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function answers():HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function scenario():BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }

    public function questionFileMediaType():MediaTypes | null
    {
        switch($this->type)
        {
            
            case QuizTypes::TEXT_2_TEXT:
                return null;
            case QuizTypes::TEXT_2_PICTURE:
                return null;
            case QuizTypes::TEXT_2_AUDIO:
                return null;
            case QuizTypes::AUDIO_2_TEXT:
                return MediaTypes::AUDIO;
            case QuizTypes::AUDIO_2_AUDIO:
                return MediaTypes::AUDIO;
            case QuizTypes::PICTURE_2_TEXT:
                return MediaTypes::PICTURE;
            case QuizTypes::PUT_IN_ORDER:
                return null;
            default:
                return null;
        }
        return null;
    }
    public function removeMediaFile(string $logo = null)
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
            $msg = "An error occurred while trying to remove media file. | ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }

    public function getMediaFile():string | null
    {
        try{
            $mediaType = $this->questionFileMediaType();
            if($mediaType == MediaTypes::AUDIO){
                $mediaFilePath = 'multimedia/'.$this->id.'/audios/'.$this->question_audio;
            } else if($mediaType == MediaTypes::PICTURE){
                $mediaFilePath = 'multimedia/'.$this->id.'/pictures/'.$this->question_picture;
            } else{
                return null;
            }
            if(Storage::exists($mediaFilePath)){
                return $mediaFilePath;
            }

            return null;
        } catch(\Exception $e){
            $msg = "An error occurred while trying to get media file ".$this->name." | ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }

    }
}
