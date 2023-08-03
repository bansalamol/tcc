<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $activeLeads = Appointment::whereIn('current_status', ['Appointment Canceled', 'Appointment Postponed', 'Visited', 'Visiting'])->count();
        $convertedLeads = Appointment::where('current_status', 'Converted')->count();
        $nonConvertedLeads = Appointment::whereNotIn('current_status', ['Converted', 'Appointment Canceled', 'Appointment Postponed', 'Visited', 'Visiting'])->count();

        return view('dashboard', compact('activeLeads', 'convertedLeads', 'nonConvertedLeads'));
    }

}
