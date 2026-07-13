<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'phone',
        'street_address',
        'city',
        'county_state',
        'country',
        'postcode',
        'passport_number',
        'passport_expiry',
        'passport_country',
        'highest_qualification',
        'institution_name',
        'graduation_year',
        'grade_achieved',
        'field_of_study',
        'english_test',
        'english_score',
        'preferred_country',
        'preferred_course',
        'intake_year',
        'intake_month',
        'budget_range',
        'additional_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        $parts = array_filter([$this->first_name, $this->last_name]);
        return count($parts) > 0 ? implode(' ', $parts) : 'Not set';
    }

    public function getCompletionPercentageAttribute(): int
    {
        $fields = [
            $this->first_name,
            $this->last_name,
            $this->date_of_birth,
            $this->gender,
            $this->nationality,
            $this->phone,
            $this->street_address,
            $this->city,
            $this->country,
            $this->postcode,
            $this->passport_number,
            $this->passport_expiry,
            $this->highest_qualification,
            $this->institution_name,
            $this->preferred_country,
            $this->preferred_course,
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($field)) {
                $filled++;
            }
        }

        return (int) (($filled / count($fields)) * 100);
    }
}
