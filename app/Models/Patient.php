<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'suffix',
        'birthdate',
        'age',
        'gender',
        'contact_no',
        'address',
        'vaccination',
        'past_history_id',
        'family_history_id',
        'social_history_id',
        'created_by',
        'status',
    ];

    public function pastHistory()
    {
        return $this->belongsTo(PastHistory::class, 'past_history_id');
    }

    public function familyHistory()
    {
        return $this->belongsTo(FamilyHistory::class, 'family_history_id');
    }

    public function socialHistory()
    {
        return $this->belongsTo(SocialHistory::class, 'social_history_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
