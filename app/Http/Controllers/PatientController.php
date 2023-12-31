<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\HealthProblems;
use App\Models\Patient;
use Illuminate\Http\Request;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $perPageRecords = 10;
        $searchTerm = '';
        if ($user->hasRole(['Administrator', 'Manager'])) {
            $patients = Patient::paginate($perPageRecords);
        } else {
            $assignedPatients = Appointment::where('assigned_to', $user->id)->pluck('patient_code')->all();;
            $patients = Patient::whereIn('code', $assignedPatients)->orWhere('created_by', $user->id)->paginate(
                $perPageRecords
            );
        }
        return view('patients.index', compact('patients', 'searchTerm'));
    }


    public function search(Request $request)
    {
        $user = auth()->user();
        $perPageRecords = 10;
        $searchTerm = $request->input('q');
        if ($user->hasRole(['Administrator', 'Manager'])) {
            $patients = Patient::where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('code', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $searchTerm . '%');
            })->paginate($perPageRecords);
        } else {
            $assignedPatients = Appointment::where('assigned_to', $user->id)->pluck('patient_code')->all();;
            $patients = Patient::whereIn('code', $assignedPatients)
                ->orWhere('created_by', $user->id)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('code', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('phone_number', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate($perPageRecords);
        }
        return view('patients.index', compact('patients', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $mobile = '')
    {
        $mobile = (is_numeric($mobile) && strlen($mobile) === 10) ? $mobile : '';
        $this->authorize('manage patients');
        return view('patients.create', compact('mobile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $this->authorize('manage patients');
        $data = $request->validated();
        Patient::create($request->validated());
        return redirect()->route('appointments.create.mobile', ['mobile' => $data['phone_number']])->with(
            'success',
            'Patient created successfully. Patient phone: ' . $data['phone_number']
        );
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
        return redirect()->route('appointments.index');
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
        $appointments = Appointment::where('patient_code', $patient->code)->orderBy('appointment_time', 'desc')->get();
        $this->authorize('manage patients');
        return view('patients.history', compact('patient', 'appointments'));
    }

    public function searchbyphone(Request $request)
    {
        // need to add a role check code & check if available in logged in users bucket
        if (auth()->check()) {
            $this->authorize('manage appointments');
            $phone = $request->query('phone');
            $phone = (is_numeric($phone) && strlen($phone) === 10) ? $phone : '';
            $phone = preg_replace('/\D/', '', $phone);
            $patients = Patient::where('phone_number', 'LIKE', "%{$phone}%")->get();

            return response()->json($patients);
        } else {
            return response()->json(['message' => 'User is not logged in'], 401);
        }
    }

}
