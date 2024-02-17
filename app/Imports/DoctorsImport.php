<?php

namespace App\Imports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\ToModel;

class DoctorsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Doctor([
            //
        ]);
    }
}
