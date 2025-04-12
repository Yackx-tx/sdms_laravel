<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
        'status_color',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record($description, $status = 'info', $status_color = 'info')
    {
        if (!Auth::check()) {
            return null;
        }
        $user = Auth::user()->name;
        $timestamp = now()->format('H:i');
        $formattedDescription = "{$user} {$description} at {$timestamp}";

        return static::create([
            'description' => $formattedDescription,
            'status' => $status,
            'status_color' => $status_color,
            'user_id' => Auth::user()->id
        ]);
    }
}
