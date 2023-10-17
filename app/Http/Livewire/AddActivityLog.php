<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;

class AddActivityLog extends Component
{
    public $appointmentId;
    public $activityType;
    public $activityDescription;

    public $isOpen = false;

    public function render()
    {
        return view('livewire.add-activity-log');
    }

    public function openModal()
    {
        $this->activityType = 'Comment'; // Set the default value
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['appointmentId','activityType', 'activityDescription']);
        $this->isOpen = false;
        $this->emit('pageReload');
    }

    public function saveActivityLog()
    {
        if (!auth()->check()) {
            $this->closeModal();
        }
        $this->validate([
            'appointmentId'=> 'required',
            'activityType' => 'nullable|string',
            'activityDescription' => 'required',
        ]);
        $description   = "Action: ".strtoupper($this->activityType)." - ".$this->activityDescription.", Added By: ".auth()->user()->name;
        ActivityLog::create([
            'appointment_id' => $this->appointmentId,
            'activity_type' => $this->activityType,
            'activity_description' => $description,
            'created_by' => auth()->user()->id,
        ]);

        $this->closeModal();
    }

}
