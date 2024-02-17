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
        return Doctor::all();
    }
}
