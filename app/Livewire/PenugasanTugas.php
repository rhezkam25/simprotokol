<?php

namespace App\Livewire;

use App\Models\AgendaTamu;
use App\Models\Tugas;
use App\Models\Pengguna;
use App\Models\Kendaraan;
use App\Services\LayananPenugasan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PenugasanTugas extends Component
{
    use WithPagination;

    public $itineraryId, $userId, $vehicleId, $notes;
    public $isModalOpen = false;

    protected $assignmentService;

    public function boot(LayananPenugasan $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function render()
    {
        $itineraries = AgendaTamu::with(['guest', 'task.user', 'task.vehicle'])
            ->latest('schedule_time')
            ->paginate(10);

        return view('livewire.task-dispatcher', [
            'itineraries' => $itineraries,
            'recommendedUsers' => Pengguna::where('role', 'ANGGOTA')->where('status', 'AKTIF')->get(),
            'availableVehicles' => Kendaraan::where('status', 'READY')->get(),
        ]);
    }

    public function openAssignModal($itineraryId)
    {
        $this->itineraryId = $itineraryId;
        
        $recommended = $this->assignmentService->getRecommendedAssignee();
        $this->userId = $recommended ? $recommended->id : null;
        
        $this->isModalOpen = true;
    }

    public function assignTask()
    {
        $this->validate([
            'userId' => 'required|exists:users,id',
            'vehicleId' => 'nullable|exists:vehicles,id',
            'notes' => 'nullable|string',
        ]);

        Tugas::updateOrCreate(
            ['guest_itinerary_id' => $this->itineraryId],
            [
                'user_id' => $this->userId,
                'vehicle_id' => $this->vehicleId,
                'status' => 'PENDING',
                'notes' => $this->notes,
            ]
        );

        Pengguna::find($this->userId)->update(['last_assigned_at' => now()]);
        
        if ($this->vehicleId) {
            Kendaraan::find($this->vehicleId)->update(['status' => 'IN_USE']);
        }

        session()->flash('message', 'Tugas berhasil diberikan.');
        $this->isModalOpen = false;
        $this->reset(['itineraryId', 'userId', 'vehicleId', 'notes']);
    }
}
