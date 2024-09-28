<?php

namespace App\Models;

use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'media_file_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function media():belongsTo
    {
        return $this->belongsTo(MediaFile::class,'media_file_id','id');
    }

    public function scenario():hasMany
    {
        return $this->hasMany(Scenario::class,'audio_background_id', 'id');
    }

}
