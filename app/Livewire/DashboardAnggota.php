<?php

namespace App\Livewire;

use App\Models\Tugas;
use App\Models\LampiranTugas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DashboardAnggota extends Component
{
    use WithFileUploads;

    public $photo;
    public $selectedTaskId;
    public $isUploadModalOpen = false;

    public function render()
    {
        $tasks = Tugas::with(['itinerary.guest', 'vehicle'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.member-dashboard', [
            'tasks' => $tasks,
        ]);
    }

    public function startTask($taskId)
    {
        Tugas::where('id', $taskId)
            ->where('user_id', auth()->id())
            ->update(['status' => 'ON_PROGRESS']);
            
        session()->flash('message', 'Tugas dimulai. Hati-hati di jalan!');
    }

    public function openUploadModal($taskId)
    {
        $this->selectedTaskId = $taskId;
        $this->isUploadModalOpen = true;
    }

    public function completeTask()
    {
        $this->validate([
            'photo' => 'required|image|max:5120', // Max 5MB
        ]);

        $task = Tugas::where('id', $this->selectedTaskId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $path = $this->photo->store('evidence', 'public');

        LampiranTugas::create([
            'task_id' => $task->id,
            'file_path' => $path,
            'type' => 'PHOTO_EVIDENCE',
        ]);

        $task->update(['status' => 'COMPLETED']);

        if ($task->vehicle_id) {
            $task->vehicle->update(['status' => 'READY']);
        }

        session()->flash('message', 'Tugas selesai. Terima kasih atas kerja kerasnya!');
        $this->isUploadModalOpen = false;
        $this->reset(['photo', 'selectedTaskId']);
    }
}
