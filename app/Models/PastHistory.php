<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'unremarkable',
        'blood_disease',
        'asthma',
        'hypertension',
        'cva',
        'gut_disease',
        'git_disease',
        'pulmo_disease',
        'previous_or',
        'previous_hospitalization',
        'other_findings',
    ];
}
