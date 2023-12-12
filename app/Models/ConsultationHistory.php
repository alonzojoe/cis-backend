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

    // public static function generateConsultationNo()
    // {
    //     $currentTime = now();
    //     $currentTimeWithSeconds = $currentTime->format('His');
    //     $milliseconds = $currentTime->format('v');
    //     $milliseconds = str_pad($milliseconds, 6, '0', STR_PAD_LEFT);

    //     return 'CON-' . $currentTime->year . '-' . $currentTime->month . '-' . $currentTimeWithSeconds;
    // }
    public static function generateConsultationNo()
    {
        $currentTime = now();
        $milliseconds = $currentTime->format('v');
        $milliseconds = str_pad($milliseconds, 2, '0', STR_PAD_LEFT);

        return 'CON-' . $currentTime->year . '-' . $currentTime->month . '-' . $currentTime->format('His') . $milliseconds;
    }

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
