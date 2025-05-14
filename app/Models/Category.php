<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Todo;

class Category extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = ['title', 'user_id']; // Pastikan kolom user_id ada di tabel categories

    /**
     * Relasi: Setiap Category dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Setiap Category bisa memiliki banyak Todo.
     */
    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

}
