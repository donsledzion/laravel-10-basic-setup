<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MediaTypes;
use App\Enums\QuizTypes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'is_correct',
        'order'
    ];

    protected $casts  = [
        'is_correct' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function quiz():BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getMediaFile():string | null
    {
        try{
            $mediaType = $this->answerFileMediaType();
            if($mediaType == MediaTypes::AUDIO){
                $mediaFilePath = 'multimedia/'.$this->quiz->scenario->organization->id.'/audios/'.$this->content;
            } else if($mediaType == MediaTypes::PICTURE){
                $mediaFilePath = 'multimedia/'.$this->quiz->scenario->organization->id.'/pictures/'.$this->content;
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

    public function answerFileMediaType():MediaTypes | null
    {
        switch($this->quiz->type)
        {
            case QuizTypes::TEXT_2_TEXT:
                return null;
                break;
            case QuizTypes::TEXT_2_PICTURE:
                return MediaTypes::PICTURE;
                break;
            case QuizTypes::TEXT_2_AUDIO:
                return MediaTypes::AUDIO;
                break;
            case QuizTypes::AUDIO_2_TEXT:
                return null;
                break;
            case QuizTypes::AUDIO_2_AUDIO:
                return MediaTypes::AUDIO;
                break;
            case QuizTypes::PICTURE_2_TEXT:
                return null;
                break;
            case QuizTypes::PUT_IN_ORDER:
                return null;
                break;
            default:
                return null;
        }
        return null;
    }

    public function removeMediaFile(string $logo = null)
    {
        try{
            if($logo == null){
                $logo = $this->getMediaFile();
                if($logo == null) return;
            } else {
                $logo = $this->getMediaFile($logo);
            }
            Storage::delete($logo);
        } catch(\Exception $e){
            $msg = "An error occurred while trying to remove media file. | ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }

    public function isFirst()
    {
        if($this->quiz->type != QuizTypes::PUT_IN_ORDER) throw new \Exception("Can't define order of non ordered type question");
        return $this->order == 1;
    }

    public function isLast()
    {
        if($this->quiz->type != QuizTypes::PUT_IN_ORDER) throw new \Exception("Can't define order of non ordered type question");
        return $this->order == $this->quiz->answers->count();
    }
}
