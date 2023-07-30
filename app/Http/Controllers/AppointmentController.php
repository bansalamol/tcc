<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\HealthProblems;
use App\Models\Patient;
use App\Models\User;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $perPageRecords = 10;
        if ($user->hasRole(['Administrator', 'Manager'])) {
            $appointments = Appointment::with('patient')->paginate($perPageRecords);
        } else {
            // Appointments created by/assigned to the user
            $appointments = $user->createdAssignedAppointments()->with('patient')->paginate($perPageRecords);

        }
        return view('appointments.index', compact('appointments'));
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
        $healthProblem = $data['health_problem'];
        $healthProblem = ((isset($data['health_problem']) && is_array($data['health_problem']))) ? $data['health_problem'] : ['Other'];
        $data['health_problem'] = implode(', ', $healthProblem);
        $appointment = Appointment::create($data);
        $healthProblemData = [];
        foreach($healthProblem as $healthProblem) {
            $healthProblemData[] = [
                'appointment_id' => $appointment->id,
                'patient_code' => $data['patient_code'],
                'comments' => $data['comments'],
                'health_problem' => $healthProblem,
            ];
        }
        HealthProblems::insert($healthProblemData);
        return redirect()->route('appointments.index');
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
        $appointments = Appointment::all();
        $users = User::all();
        return view('appointments.edit', compact('appointment','appointments','users'));
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
        $appointment->update($data);
        $healthProblemData = [];
        foreach($healthProblem as $healthProblem) {
            $healthProblemData[] = [
                'appointment_id' => $appointment->id,
                'patient_code' => $data['patient_code'],
                'comments' => $data['comments'],
                'health_problem' => $healthProblem,
            ];
        }
        HealthProblems::where('appointment_id', $appointment->id)->delete();
        HealthProblems::insert($healthProblemData);
        return redirect()->route('appointments.index');
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
