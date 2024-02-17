<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //

    public function index()
    {
        return Doctor::all();
    }


    public function getdata()
    {
    }
}
