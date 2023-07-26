<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Appointment;
use App\Models\HealthProblems;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole(['Administrator', 'Manager'])) {
            $patients = Patient::all();
        } else {
        $patientsCreatedByUser = Patient::where('created_by', $user->id)->get();
        $assignedPatients = Appointment::where('assigned_to', $user->id)->pluck('patient_code')->all();;
        $patientsAssignedToUser = Patient::whereIn('code', $assignedPatients)->get();
        // Merge the two collections into a single collection
        $patients = $patientsCreatedByUser->merge($patientsAssignedToUser);
        }
        return view('patients.index', compact('patients'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manage patients');
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $this->authorize('manage patients');

        Patient::create($request->validated());
        return redirect()->route('patients.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $this->authorize('manage patients');
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $this->authorize('manage patients');

        $patient->update($request->validated());
        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('manage patients');

        $patient->delete();
        return redirect()->route('patients.index');
    }

    /**
     * Show the history the specified resource.
     */
    public function history(int $id)
    {
        $patient = Patient::find($id);
        if (empty($patient)) {
            return redirect()->route('patients.index');
        }
        // $healthProblems = HealthProblems::where('patient_code', $patient->code)->get();
        $appointments = Appointment::where('patient_code', $patient->code)->orderBy('appointment_time', 'desc')->get();
        $this->authorize('manage patients');
        return view('patients.history', compact('patient','appointments'));
    }

}
