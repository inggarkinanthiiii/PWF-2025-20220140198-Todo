<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Todo extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'title',
        'user_id',
        'is_done',
    ];

    // Cast is_done menjadi boolean agar konsisten saat digunakan
    protected $casts = [
        'is_done' => 'boolean',
    ];

    /**
     * Relasi: Setiap Todo dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
