<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuizTypes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scenarios():BelongsToMany
    {
        return $this->belongsToMany(Scenario::class);
    }
}
