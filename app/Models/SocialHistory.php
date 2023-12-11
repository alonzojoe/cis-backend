<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'smoking',
        'alcohol_intake',
        'betel_nut_chewing',
        'drug_food_allergy',
        'others',
    ];
}
