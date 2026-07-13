<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'patient_age',
        'patient_gender',
        'appointment_date',
        'appointment_time',
        'consult_type',
        'reason',
        'symptoms',
        'fee',
        'payment_status',
        'status',
        'doctor_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
