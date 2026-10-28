<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'film_id',
        'content',
        'point'
    ];

    // Relasi: Review ini milik siapa? (Milik User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Siapa saja yang like review ini?
    public function likes()
    {
        return $this->belongsToMany(User::class, 'review_user');
    }
}