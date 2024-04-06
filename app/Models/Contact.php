<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;
    protected $table='contacts';
    protected $fillable=[
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'user_id'
    ];
    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }
}
