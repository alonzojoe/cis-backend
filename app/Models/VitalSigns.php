<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSigns extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'height',
        'weight',
        'bmi',
        'bp_f',
        'bp_s',
        'oxygen_saturation',
        'temperature',
        'respiratory_rate',
        'pulse_rate',
        'cbg',
    ];


    public function consultation()
    {
        return $this->belongsTo(ConsultationHistory::class);
    }
}
