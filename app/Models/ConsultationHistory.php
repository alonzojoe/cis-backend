<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationHistory extends Model
{
    use HasFactory;
    protected $table = "consultation_history";
    protected $fillable = [
        'patient_id',
        'physician_id',
        'consultation_no',
        'consultation_datetime',
        'payment_type',
        'chief_complaint',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'status',
        'created_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function physician()
    {
        return $this->belongsTo(Physician::class, 'physician_id');
    }

    public function vitalSigns()
    {
        return $this->hasOne(VitalSigns::class, 'consultation_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
