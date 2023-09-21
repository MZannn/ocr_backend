<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function getAllResidents()
    {
        $residents = resident::all();
        return ResponseFormatter::success(
            $residents,
            'Data Resident Berhasil Diambil'
        );
    } 
}