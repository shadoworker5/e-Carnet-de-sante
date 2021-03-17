<?php

namespace App\Imports;

use App\Models\Regions;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Regions([
            'user_id'       => Auth::id(),
            'contries_id'   => $row['identifiant_pays'],
            'code_region'   => $row['code_region'],
            'title'         => $row['title'],
            'description'   => $row['description']
        ]);
    }
}
