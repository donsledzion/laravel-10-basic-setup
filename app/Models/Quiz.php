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
use SebastianBergmann\Type\NullType;

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

    public function getQuestionAudioFileFullPath(): string
    {
        if($this->question_audio == null) return '';
        if(!asset('organizations'.'/'.$this->scenario->organization->id.'/pictures/'.$this->question_audio)) return '';
        return asset('organizations'.'/'.$this->scenario->organization->id.'/pictures/'.$this->question_audio);
    }

    public function getQuestionPictureFileFullPath(): string
    {
        if($this->question_picture == null) return '';
        if(!asset('organizations'.'/'.$this->scenario->organization->id.'/pictures/'.$this->question_picture)) return '';
        return asset('organizations'.'/'.$this->scenario->organization->id.'/pictures/'.$this->question_picture);
    }

    public function questionFileMediaType():MediaTypes | null
    {
        switch($this->type)
        {
            case QuizTypes::TEXT_2_TEXT:
                return null;
                break;
            case QuizTypes::TEXT_2_PICTURE:
                return null;
                break;
            case QuizTypes::TEXT_2_AUDIO:
                return null;
                break;
            case QuizTypes::AUDIO_2_TEXT:
                return MediaTypes::AUDIO;
                break;
            case QuizTypes::AUDIO_2_AUDIO:
                return MediaTypes::AUDIO;
                break;
            case QuizTypes::PICTURE_2_TEXT:
                return MediaTypes::PICTURE;
                break;
            case QuizTypes::PUT_IN_ORDER:
                return null;
                break;
            default:
                return null;
        }
        return null;
    }

    public function answerFileMediaType():MediaTypes | null
    {
        switch($this->type)
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


    public function reorderAnswers()
    {
        if($this->type != QuizTypes::PUT_IN_ORDER) return;
        if($this->answers->count() < 1) return;

        $order = 0;
        foreach( $this->answers->sortBy('order') as $answer ){
            $order++;
            $answer->order = $order;
            $answer->save();
        }
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

    public function getMediaFile():string | null
    {
        try{
            $mediaType = $this->questionFileMediaType();
            if($mediaType == MediaTypes::AUDIO){
                $mediaFilePath = 'multimedia/'.$this->scenario->organization->id.'/audios/'.$this->question_audio;
            } else if($mediaType == MediaTypes::PICTURE){
                $mediaFilePath = 'multimedia/'.$this->scenario->organization->id.'/pictures/'.$this->question_picture;
            } else{
                return null;
            }
            error_log("MediaFilePath: ".$mediaFilePath);
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
