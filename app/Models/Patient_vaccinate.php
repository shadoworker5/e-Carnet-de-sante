<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient_vaccinate extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'patient_id', 'vaccine_calendar_id', 'date_vacination', 'time_vacination', 'name_doctor', 'doctor_contact', 'lot_number_vacine', 'rappelle', 'vacine_status', 'path_capture', 'validity_vacine'];
}
