<?php

namespace App\Http\Controllers;

use App\Imports\DoctorsImport;
use App\Models\Doctor;
use App\Models\User;
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
        $users = User::count();
        $doctors_count = Doctor::count();
        return view('Doctors', ['doctors' => $doctors, 'doctors_count' => $doctors_count, 'userscount' => $users]);
    }

    public function add_page()
    {
        return view('Add');
    }

    public function store_doctor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable|string',
            'gover' => 'required',
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
            'rate' => 'nullable|numeric|max:5'
        ]);

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->gover = $request->gover;
        $doctor->lat = $request->lat;
        $doctor->lang = $request->lang;
        if ($request->rate == null) {
            $doctor->rate = 0;
        } else {
            $doctor->rate = $request->rate;
        }
        $doctor->save();
        return redirect('/admindash');
    }

    public function edit_doctor($id)
    {
        $doctor = Doctor::find($id);

        return view('Edit', ['doctor' => $doctor]);
    }

    public function update_doctor($id, Request $requset)
    {
        $requset->validate([
            'name' => 'required',
            'phone' => 'nullable|string',
            'gover' => 'required',
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
            'rate' => 'nullable|numeric|max:5'
        ]);

        $doctor = Doctor::find($id);
        $doctor->name = $requset->name;
        $doctor->phone = $requset->phone;
        $doctor->gover = $requset->gover;
        $doctor->lat = $requset->lat;
        $doctor->lang = $requset->lang;
        if ($requset->rate == null) {
            $doctor->rate = 0;
        } else {
            $doctor->rate = $requset->rate;
        }
        $doctor->update();
        return redirect('/admindash');
    }

    public function delete_doctor($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();
        return back();
    }
}
