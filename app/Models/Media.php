<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    // Ditulis eksplisit supaya tidak bergantung pada tebakan pluralisasi Laravel
    protected $table = 'media';

    protected $fillable = ['title', 'type', 'genre', 'release_year', 'description'];

    protected $casts = [
        'release_year' => 'integer',
    ];

    // Satu Media bisa dikoleksi banyak Pengguna
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
