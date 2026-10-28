<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmRequest extends Model
{
    use HasFactory;

    // PASTIKAN SEMUA KOLOM BARU ADA DI SINI 
    protected $fillable = [
        'user_id', 
        'title', 
        'year', 
        'poster_url', 
        'note', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}