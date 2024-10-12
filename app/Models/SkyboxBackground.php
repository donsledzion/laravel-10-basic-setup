<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkyboxBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'texture_id',
        'thumbnail_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function texture():belongsTo
    {
        return $this->belongsTo(MediaFile::class,'texture_id','id');
    }
    public function thumbnail():belongsTo
    {
        return $this->belongsTo(MediaFile::class,'thumbnail_id','id');
    }

    public function scenario():hasMany
    {
        return $this->hasMany(Scenario::class,'skybox_background_id', 'id');
    }
}
