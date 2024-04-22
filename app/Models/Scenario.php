<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scenario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'pin'
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
}
