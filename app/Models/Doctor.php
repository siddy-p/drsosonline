<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'specialty',
        'qualification',
        'bio',
        'languages',
        'photo_url',
        'years_experience',
        'available_days',
        'available_from',
        'available_to',
        'fee_phone',
        'fee_video',
        'rating',
        'total_consultations',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'double',
        'years_experience' => 'integer',
        'total_consultations' => 'integer',
        'fee_phone' => 'integer',
        'fee_video' => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute($value): string
    {
        if (str_starts_with($value, '/static/')) {
            return str_replace('/static/', '', $value);
        }
        return $value ?? 'images/default_doctor.png';
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class)->latest();
    }

    public function getLanguageListAttribute(): array
    {
        return array_filter(array_map('trim', explode(',', $this->languages ?? '')));
    }

    public function getAvailableDayListAttribute(): array
    {
        return array_filter(array_map('trim', explode(',', $this->available_days ?? '')));
    }
}
