<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'treatment_id',
        'date'
    ];

    protected $hidden = [
        'doctor_id',
        'patient_id',
        'treatment_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];
    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function treatment(){
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }
}
