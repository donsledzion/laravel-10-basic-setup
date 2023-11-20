<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'code',
        'device',
        'expires_at',
        'description',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' =>   'datetime',
        'updated_at' =>   'datetime',
        'code' => 'string'
    ];
}
