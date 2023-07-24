<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_code',
        'call_datetime',
        'clinic',
        'appointment_type',
        'lead_interest_score',
        'health_problem',
        'current_status',
        'cancelation_reason',
        'comments',
        'assigned_to', 
        'reference_id',
        'missed_appointment_executive_id',
        'active',
        'visited',
        'last_called_datetime',
        'last_messaged_datetime'
    ];

    protected static function boot()
    {

        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }
    

}
