<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class APIPatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'added_by'          => $this->added_by,
            'code_patient'      => $this->code_patient,
            'full_name'         => $this->full_name,
            'birthday'          => $this->birthday,
            'name_father'       => $this->name_father,
            'name_mother'       => $this->name_mother,
            'name_mentor'       => $this->name_mentor,
            'helper_contact'    => $this->helper_contact,
            'helper_email'      => $this->helper_email
        ];
    }
}
