<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    protected $fillable = [
        'change_id',
        'key',
        'content_before',
        'content_after',
    ];
}
