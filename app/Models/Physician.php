<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physician extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_no',
        'lname',
        'fname',
        'mname',
        'status',
    ];
}
