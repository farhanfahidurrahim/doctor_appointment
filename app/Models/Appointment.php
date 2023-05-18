<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'appointment_no',
        'appointment_date',
        'patient_name',
        'patient_phone',
        'total_fee',
        'paid_amount',
    ];
}
