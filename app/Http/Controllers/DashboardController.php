<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index_old()
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

    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        if (auth()->user()->hasRole(['Administrator'])) {
            $users =  User::where('id', '!=', '1')->get();

        } else {
            $users =  User::where('id', '!=', '1')->where('manager_id', auth()->id())->get();
        }


        // Assuming your model is named Appointment
        $maxVisitedUser = 0;
        $maxVisitedUser = Appointment::select('assigned_to', DB::raw('COUNT(*) as visited_count'))
            ->where('visited', 'Visited')
            ->whereBetween('appointment_time', [
                Carbon::now()->startOfWeek()->subWeek(), // Start of the previous week
                Carbon::now()->startOfWeek()              // Start of the current week
            ])
            ->groupBy('assigned_to')
            ->orderByDesc('visited_count')
            ->first();
        $totalAppointmentsUser = 0;
        $userDetails = '';
        $visitedRatioUser = 0;
        if ($maxVisitedUser) {
            $userDetails = User::find($maxVisitedUser->assigned_to);
            $totalAppointmentsUser = Appointment::where('assigned_to', $userDetails->id)
                ->whereBetween('appointment_time', [
                    Carbon::now()->startOfWeek()->subWeek(), // Start of the previous week
                    Carbon::now()->startOfWeek()              // Start of the current week
                ])
                ->count();


            if ($maxVisitedUser > 0 && $totalAppointmentsUser > 0) {
                $visitedRatioUser = ($maxVisitedUser / $totalAppointmentsUser) * 100;
            }
        }

        // Get today's date
        $today = Carbon::today();
        $leadsType = [
            'Fix Appointment',
            'Interested Lead',
            'Non interested',
            'Prospective lead',
            'Tentative Appointment',
            'Rescheduled Appointment',
            'RemoteConsultation Appointment'
        ];
        // 1. Leads/Calls for today
        $leadsCallsToday = Appointment::whereIn(
            'appointment_type',
            $leadsType
        )
            ->whereDate('appointment_time', $today)
            ->count();

        // 2. Enquiry for today
        $enquiryToday = Appointment::where('appointment_type', 'Followup')
            ->whereDate('appointment_time', $today)
            ->count();

        // 3. Appointments for today
        $appointmentsToday = Appointment::whereIn('appointment_type', ['Confirmed', 'Appointment Scheduled'])
            ->whereDate('appointment_time', $today)
            ->count();

        // 4. Visited Ratio for today
        $totalAppointmentsToday = Appointment::whereDate('appointment_time', $today)->count();
        $visitedToday = Appointment::whereDate('appointment_time', $today)
            ->whereIn('visited', ['Visited', 'Dubplicate Visited'])
            ->count();
        $visitedRatioToday = 0;
        if ($visitedToday > 0 && $totalAppointmentsToday > 0) {
            $visitedRatioToday = ($visitedToday / $totalAppointmentsToday) * 100;
        }

        $threeDaysAgo = Carbon::today()->subDays(3);

        // 1. Leads/Calls for the last 3 days
        $leadsCalls3Days = Appointment::where('appointment_type', $leadsType)
            ->whereBetween('appointment_time', [$threeDaysAgo, $today])
            ->count();

        // 2. Enquiry for the last 3 days
        $enquiry3Days = Appointment::where('appointment_type', 'Followup')
            ->whereBetween('appointment_time', [$threeDaysAgo, $today])
            ->count();

        // 3. Appointments for the last 3 days
        $appointments3Days = Appointment::where('appointment_type', ['Confirmed', 'Appointment Scheduled'])
            ->whereBetween('appointment_time', [$threeDaysAgo, $today])
            ->count();


        $totalAppointments3Days = Appointment::whereBetween('appointment_time', [$threeDaysAgo, $today])->count();
        $visited3Days = Appointment::whereBetween('appointment_time', [$threeDaysAgo, $today])
            ->whereIn('visited', ['Visited', 'Dubplicate Visited'])
            ->count();

        $visitedRatio3Days = 0;
        if ($visited3Days > 0 && $totalAppointments3Days > 0) {
            $visitedRatio3Days = ($visited3Days / $totalAppointments3Days) * 100;
        }

        $sevenDaysAgo = Carbon::today()->subDays(7);

// 1. Leads/Calls for the last 7 days
        $leadsCalls7Days = Appointment::where('appointment_type', 'Leads/Calls')
            ->whereBetween('appointment_time', [$sevenDaysAgo, $today])
            ->count();

// 2. Enquiry for the last 7 days
        $enquiry7Days = Appointment::where('appointment_type', 'Enquiry')
            ->whereBetween('appointment_time', [$sevenDaysAgo, $today])
            ->count();

// 3. Appointments for the last 7 days
        $appointments7Days = Appointment::where('appointment_type', 'Appointments')
            ->whereBetween('appointment_time', [$sevenDaysAgo, $today])
            ->count();

// 4. Visited Ratio for the last 7 days
        $totalAppointments7Days = Appointment::whereBetween('appointment_time', [$sevenDaysAgo, $today])->count();
        $visited7Days = Appointment::whereBetween('appointment_time', [$sevenDaysAgo, $today])
            ->whereIn('visited', ['Visited', 'Dubplicate Visited'])
            ->count();
        $visitedRatio7Days = 0;
        if ($visited7Days > 0 && $totalAppointments7Days > 0) {
            $visitedRatio7Days = ($visited7Days / $totalAppointments7Days) * 100;
        }
        return view('dashboard', compact('searchTerm','maxVisitedUser','totalAppointmentsUser','userDetails','visitedRatioUser','leadsCallsToday', 'enquiryToday', 'appointmentsToday', 'visitedRatioToday','leadsCalls3Days','enquiry3Days','appointments3Days','visitedRatio3Days','leadsCalls7Days','enquiry7Days','appointments7Days','visitedRatio7Days'));

    }

}
