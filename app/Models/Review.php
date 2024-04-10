<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'comment',
        'date',
        'user_id',
        'reviewed_at'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
