<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_url',
        'randomized_string',
        'accuracy_percentage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
