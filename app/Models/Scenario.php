<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Scenario extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function quizzes():BelongsToMany
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function organizations():BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
