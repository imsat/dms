<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'new_version',
        'old_version',
    ];

    public function newVersion()
    {
        return $this->belongsTo(DocumentVersion::class, 'document_id')->where('version', '=', $this->new_version);
    }

    public function oldVersion()
    {
        return $this->belongsTo(DocumentVersion::class, 'document_id')->where('version', '=', $this->old_version);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
