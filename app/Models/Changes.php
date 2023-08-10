<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changes extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'version',
        'last_viewed_version',
        'status',
    ];
}
