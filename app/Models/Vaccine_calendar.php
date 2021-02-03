<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine_calendar extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'patient_age', 'name_vaccine', 'illness_against', 'status'];
}
