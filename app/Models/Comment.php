<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $fillable = [
        'user_id',
        'content',
        'post',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post', 'id');
    }
}
