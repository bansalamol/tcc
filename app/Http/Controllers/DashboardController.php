<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $leadsQuery = Appointment::query();

        if ($user->hasRole(['Manager'])) {
            $subordinateIds = User::where('manager_id', $user->id)->pluck('id')->toArray();
            $subordinateIds[] = $user->id; // added to see records created by manager or assigned to manager
            $leadsQuery->whereIn('appointments.created_by', $subordinateIds)
                ->orWhereIn('appointments.assigned_to', $subordinateIds);
        } else {
            if ($user->hasRole(['Presales'])) {
                $leadsQuery->where('appointments.created_by', $user->id)
                    ->orWhere('appointments.assigned_to', $user->id);
            }
        }
        $activeLeadsCount = clone $leadsQuery;
        $convertedLeadsCount = clone $leadsQuery;
        $nonConvertedLeadsCount = clone $leadsQuery;

        $activeLeads = $activeLeadsCount->whereIn('active', ['Yes'])->count();
        $convertedLeads = $convertedLeadsCount->where('current_status', 'Converted')->count();
        $nonConvertedLeads = $nonConvertedLeadsCount->whereNotIn(
            'current_status',
            ['Appointment Canceled', 'Appointment Postponed', 'Visiting']
        )->count();

        return view('dashboard', compact('activeLeads', 'convertedLeads', 'nonConvertedLeads'));
    }

}
