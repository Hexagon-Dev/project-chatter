<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public const TYPE_CLIENT = 'client';
    public const TYPE_CLIENT_MODERATOR = 'client_moderator';
    public const TYPE_MODERATOR = 'moderator';
    public const TYPE_PROGRAMMER = 'programmer';
    public const TYPE_C_CM = 'c_cm';
    public const TYPE_CM_M = 'cm_m';
    public const TYPE_M_P = 'm_p';
    
    public const TYPES = [
        self::TYPE_CLIENT,
        self::TYPE_CLIENT_MODERATOR,
        self::TYPE_MODERATOR,
        self::TYPE_PROGRAMMER,
        self::TYPE_C_CM,
        self::TYPE_CM_M,
        self::TYPE_M_P,
    ];

    protected $guarded = [];

    public $timestamps = false;
}
