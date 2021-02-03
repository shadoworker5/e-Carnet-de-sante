<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientVacinateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_code'          => 'required|min:8',
            'vaccine_name'          => 'required',
            'date_vaccinate'        => 'required|date',
            'time_vaccinate'        => 'required',
            'doctor_name'           => 'required|min:5',
            'doctor_phone'          => 'required|min:10',
            'lot_number_vaccine'    => 'required|min:5',
        ];
    }
}
