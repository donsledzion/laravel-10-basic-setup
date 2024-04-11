<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function organization():BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
