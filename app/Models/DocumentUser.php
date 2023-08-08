<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
    use HasFactory;

    protected $fillable = [
      'document_id',
      'user_id',
      'last_viewed_version',
    ];
}
