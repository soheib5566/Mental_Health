<?php

namespace Database\Seeders;

use App\Imports\DoctorsImport;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $doctorsjson = file_get_contents('database/seeders/json/Doctors_Locations-_ENG_.json');

        $doctorsdata = json_decode($doctorsjson);

        foreach ($doctorsdata as $doctor) {
            $id = $doctor->ID;
            $lat = $doctor->Lat;
            $long = $doctor->Long;
            $name = $doctor->Description;
            $rate = $doctor->Rate;
            $gover = $doctor->Governorate;
            $phone = $doctor->Phone;

            Doctor::create([
                'id' => $id,
                'lang' => $long,
                'lat' => $lat,
                'name' => $name,
                'phone' => $phone,
                'gover' => $gover,
                'rate' => $rate,
            ]);
        }
    }
}
