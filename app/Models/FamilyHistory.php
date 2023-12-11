<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'unremarkable',
        'hcvd',
        'chd',
        'cva',
        'gut_disease',
        'blood_dyscrasia',
        'allergy',
        'dm',
        'git_disease',
        'pulmo_disease',
        'ca',
        'other_findings',
    ];
}
