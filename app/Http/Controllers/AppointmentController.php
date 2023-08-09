<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\HealthProblems;
use App\Models\Patient;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPageRecords = 10;
        $defaultLastDays = 30;
        $user = auth()->user();

        $searchFilter = $request->input('search_filter');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $currentStatus = $request->input('status');
        $name = $request->input('pname');

        $sortField = request()->input('sortField', 'id');
        $sortDirection = request()->input('sortDirection', 'desc');
        $dbQuery = Appointment::with('patient');

        if ($user->hasRole(['Administrator'])) {
            // show all
        } else if ($user->hasRole(['Manager'])) {
            $subordinateIds = User::where('manager_id', $user->id)->pluck('id')->toArray();
            $subordinateIds[] = $user->id; // added to see records created by manager or assigned to manager
            $dbQuery
                ->where(function ($query) use ($user, $subordinateIds) {
                    $query->whereIn('appointments.created_by', $subordinateIds)
                        ->orWhereIn('appointments.assigned_to', $subordinateIds);
                });
        } else if ($user->hasRole(['Presales'])) {
            $dbQuery
                ->where(function ($query) use ($user) {
                    $query->where('appointments.created_by', $user->id);
                    $query->orWhere('appointments.assigned_to', $user->id);
                });
        } else {
            throw new Exception("Role not supported");
        }

        if ($searchFilter === 'date_range' && $startDate && $endDate) {
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate)); // Set the time to the beginning of the day
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));     // Set the time to the end of the day
            $dbQuery->whereBetween('appointments.created_at', [$startDate, $endDate]);
        } elseif ($searchFilter === 'status' && $currentStatus) {
            $dbQuery->where('appointments.current_status', $currentStatus);
        } elseif ($searchFilter === 'pname' && $name) {
            $dbQuery->whereHas('patient', function ($query) use ($name) {
                $query->where('patients.name', 'like', '%' . $name . '%');
            });
        } else {
            // Default condition if no specific filter is selected
            $dbQuery->whereDate('appointments.created_at', '>=', date("Y-m-d", strtotime("-$defaultLastDays days")));
        }
    

        $appointments = $dbQuery
            ->join('patients', 'appointments.patient_code', '=', 'patients.code')
            ->select('appointments.*', 'patients.name as patient_name')
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPageRecords);

        return view('appointments.index', compact('appointments','searchFilter', 'sortField', 'sortDirection', 'endDate', 'startDate', 'currentStatus','name'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manage appointments');
        $patients = Patient::all();
        $users = User::all();
        $appointments = Appointment::all();
        return view('appointments.create', compact('patients', 'users', 'appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $this->authorize('manage appointments');
        $data = $request->validated();
        $data['assigned_to'] = auth()->id();

        $healthProblem = $data['health_problem'];
        $healthProblem = ((isset($data['health_problem']) && is_array($data['health_problem']))) ? $data['health_problem'] : ['Other'];
        $data['health_problem'] = implode(', ', $healthProblem);
        $comments = $data['comments'];
        unset($data['health_problem'], $data['comments']);
        $appointment = Appointment::create($data);
        $healthProblemData = [];
        foreach ($healthProblem as $healthProblem) {
            $healthProblemData[] = [
                'appointment_id' => $appointment->id,
                'patient_code' => $data['patient_code'],
                'comments' => $comments,
                'health_problem' => $healthProblem,
            ];
        }
        HealthProblems::insert($healthProblemData);
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully. Patient Code: ' . $data['patient_code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $this->authorize('manage appointments');
        $appointment->load('healthProblems');
        $healthPromlemData = [];
        foreach ($appointment->healthProblems as $healthProblem) {
            $appointment->comments = $healthProblem->comments;
            $healthPromlemData[] = $healthProblem->health_problem;
        }
        $appointment->health_problem = implode(', ', $healthPromlemData);
        $appointments = Appointment::all();

        $user = auth()->user();
        if($user->id === $appointment->created_by || $user->id === $appointment->assigned_to){
            $users = User::all();
        }else{
            $users = User::where('id','!=',$user->id)->get();
        }
        
        return view('appointments.edit', compact('appointment', 'appointments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize('manage appointments');
        $data = $request->validated();
        $healthProblem = $data['health_problem'];
        $healthProblem = ((isset($data['health_problem']) && is_array($data['health_problem']))) ? $data['health_problem'] : ['Other'];
        $data['health_problem'] = implode(', ', $healthProblem);
        $healthProblemData = [];
        foreach ($healthProblem as $healthProblem) {
            $healthProblemData[] = [
                'appointment_id' => $appointment->id,
                'patient_code' => $data['patient_code'],
                'comments' => $data['comments'],
                'health_problem' => $healthProblem,
            ];
        }
        unset($data['health_problem'], $data['comments']);
        $appointment->update($data);
        HealthProblems::where('appointment_id', $appointment->id)->delete();
        HealthProblems::insert($healthProblemData);
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully. Patient Code: ' . $data['patient_code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index');
    }
}
