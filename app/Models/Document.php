<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'current_version',
        'status',
    ];

    public function documentVersion()
    {
        return $this->hasMany(DocumentVersion::class)->where('version', '=', $this->current_version);
    }

    public function documentVersions()
    {
        return $this->hasMany(DocumentVersion::class);
    }
}
