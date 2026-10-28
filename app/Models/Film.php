<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi data
    protected $fillable = [
        'title',
        'slug',
        'synopsis',
        'poster',
        'banner',
        'release_year',
        'director',
        'genre',
        'cast',
        'duration', 
        'is_popular',
    ];
    // Relasi: Film ini punya banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class); // Sambungkan ke model Review
    }

    // Film ini ada di banyak playlist
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'film_playlist');
    }
}