<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'specialist_user_id',
        'pharmacist_user_id',
        'billing_user_id',
        'notes'
    ];
}
