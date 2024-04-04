<?php

namespace App\Http\Controllers;

use App\Imports\DoctorsImport;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DoctorController extends Controller
{
    //

    public function index()
    {
        $doctors = Doctor::all();

        // Prepare an array to hold JSON data for all doctors
        $doctorsData = [];

        foreach ($doctors as $doctor) {
            // Access properties of each doctor model
            $doctorData = [
                'id' => $doctor->id,
                'lat' => $doctor->lat,
                'lang' => $doctor->lang,
                'name' => $doctor->name,
                'phone' => $doctor->phone,
                'gover' => $doctor->gover,
                'rate' => $doctor->rate
            ];

            // Add data for this doctor to the array
            $doctorsData[] = $doctorData;
        }

        // Return the JSON response containing data for all doctors
        return response()->json($doctorsData);
    }

    public function indexdoctors()
    {
        $doctors = Doctor::all();
        return view('Doctors', ['doctors' => $doctors]);
    }

    public function add_page()
    {
        return view('Add');
    }
}
