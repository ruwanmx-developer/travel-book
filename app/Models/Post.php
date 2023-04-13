<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $table = 'post';
    protected $fillable = [
        'description',
        'content_url',
        'content_type',
        'uploaded_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
