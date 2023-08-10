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
        $defaultLastDays = 3;
        $user = auth()->user();

        $cstartDate = $request->input('cstart_date');
        $cendDate = $request->input('cend_date');
        $astartDate = $request->input('astart_date');
        $aendDate = $request->input('aend_date');
        $currentStatus = $request->input('status');
        $mobile = $request->input('mobile');
        $mobile = (is_numeric($mobile) && strlen($mobile) === 10) ? $mobile : '';
        $name = $request->input('pname');
        $defaultFilter = true;

        $sortField = request()->input('sortField', 'id');
        $sortDirection = request()->input('sortDirection', 'desc');
        $dbQuery = Appointment::with('patient');

        if ($user->hasRole(['Administrator'])) {
            // show all
        } else {
            if ($user->hasRole(['Manager']) && empty($mobile)) {
                $subordinateIds = User::where('manager_id', $user->id)->pluck('id')->toArray();
                $subordinateIds[] = $user->id; // added to see records created by manager or assigned to manager
                $dbQuery
                    ->where(function ($query) use ($user, $subordinateIds) {
                        $query->whereIn('appointments.created_by', $subordinateIds)
                            ->orWhereIn('appointments.assigned_to', $subordinateIds);
                    });
            } else {
                if ($user->hasRole(['Presales']) && empty($mobile)) {
                    $dbQuery
                        ->where(function ($query) use ($user) {
                            $query->where('appointments.created_by', $user->id);
                            $query->orWhere('appointments.assigned_to', $user->id);
                        });
                }
            }
        }

        if ($currentStatus) {
            $dbQuery->where('appointments.current_status', $currentStatus);
            $defaultFilter = false;
        }
        if ($name) {
            $dbQuery->whereHas('patient', function ($query) use ($name) {
                $query->where('patients.name', 'like', '%' . $name . '%');
            });
            $defaultFilter = false;
        }
        if ($mobile) {
            $dbQuery->whereHas('patient', function ($query) use ($mobile) {
                $query->where('patients.phone_number', 'like', '%' . $mobile . '%');
            });
            $defaultFilter = false;
        }
        if ($cstartDate && $cendDate) {
            $cstartDate = date('Y-m-d 00:00:00', strtotime($cstartDate)); // Set the time to the beginning of the day
            $cendDate = date('Y-m-d 23:59:59', strtotime($cendDate));     // Set the time to the end of the day
            $dbQuery->whereBetween('appointments.created_at', [$cstartDate, $cendDate]);
            $defaultFilter = false;
        }
        if ($astartDate && $aendDate) {
            $astartDate = date('Y-m-d 00:00:00', strtotime($astartDate)); // Set the time to the beginning of the day
            $aendDate = date('Y-m-d 23:59:59', strtotime($aendDate));     // Set the time to the end of the day
            $dbQuery->whereBetween('appointments.appointment_time', [$astartDate, $aendDate]);
            $defaultFilter = false;
        }

        if ($defaultFilter) {
            $dbQuery->whereDate('appointments.created_at', '>=', date("Y-m-d", strtotime("-$defaultLastDays days")));
        }

        $appointments = $dbQuery
            ->join('patients', 'appointments.patient_code', '=', 'patients.code')
            ->select('appointments.*', 'patients.name as patient_name')
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPageRecords);

        return view(
            'appointments.index',
            compact(
                'appointments',
                'sortField',
                'sortDirection',
                'astartDate',
                'aendDate',
                'cstartDate',
                'cendDate',
                'currentStatus',
                'name',
                'mobile'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($mobile = '')
    {
        $this->authorize('manage appointments');
        $patients = Patient::all();
        $users = User::all();
        $appointments = Appointment::all();
        return view('appointments.create', compact('patients', 'users', 'appointments', 'mobile'));
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
        $healthProblem = ((isset($data['health_problem']) && is_array(
                $data['health_problem']
            ))) ? $data['health_problem'] : ['Other'];
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
        return redirect()->route('appointments.index')->with(
            'success',
            'Appointment created successfully. Patient Code: ' . $data['patient_code']
        );
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
        if ($user->id === $appointment->created_by || $user->id === $appointment->assigned_to) {
            $users = User::all();
        } else {
            $users = User::where('id', '!=', $user->id)->get();
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
        $healthProblem = ((isset($data['health_problem']) && is_array(
                $data['health_problem']
            ))) ? $data['health_problem'] : ['Other'];
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
        return redirect()->route('appointments.index')->with(
            'success',
            'Appointment updated successfully. Patient Code: ' . $data['patient_code']
        );
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
