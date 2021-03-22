<?php

namespace App\Imports;

use App\Models\Provinces;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvinceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Provinces([
            'user_id'   => Auth::id(),
            'region_id' => session('region_id'),
            'title'     => $row['title']
        ]);
    }
}
