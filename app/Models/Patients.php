<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'birthday', 'name_father', 'name_mother', 'name_mentor', 'name_mentor', 'helper_contact', 'helper_email', 'user_id', 'code_patient', 'genre', 'born_location'];
}
