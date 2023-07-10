<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'treatmentName',
        'description'
    ];

    public function appointment(){
        return $this->hasMany(Appointment::class, 'treatment_id');
    }
}
