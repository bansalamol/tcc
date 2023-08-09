<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $activeLeads = Appointment::whereIn('active', ['Yes'])->count();
        $convertedLeads = Appointment::where('current_status', 'Converted')->count();
        $nonConvertedLeads = Appointment::whereNotIn('current_status', [ 'Appointment Canceled', 'Appointment Postponed', 'Visiting'])->count();

        return view('dashboard', compact('activeLeads', 'convertedLeads', 'nonConvertedLeads'));
    }

}
