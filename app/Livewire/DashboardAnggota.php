<?php
1: 
2: namespace App\Livewire;
3: 
4: use App\Models\Tugas;
5: use App\Models\LampiranTugas;
6: use Livewire\Component;
7: use Livewire\WithFileUploads;
8: use Livewire\Attributes\Layout;
9: 
10: #[Layout('layouts.app')]
11: class DashboardAnggota extends Component
12: {
13:     use WithFileUploads;
14: 
15:     public $photo;
16:     public $selectedTaskId;
17:     public $isUploadModalOpen = false;
18: 
19:     public function render()
20:     {
21:         $tasks = Tugas::with(['itinerary.guest', 'vehicle'])
22:             ->where('user_id', auth()->id())
23:             ->latest()
24:             ->get();
25: 
26:         return view('livewire.member-dashboard', [
27:             'tasks' => $tasks,
28:         ]);
29:     }
30: 
31:     public function startTask($taskId)
32:     {
33:         Tugas::where('id', $taskId)
34:             ->where('user_id', auth()->id())
35:             ->update(['status' => 'ON_PROGRESS']);
36:             
37:         session()->flash('message', 'Tugas dimulai. Hati-hati di jalan!');
38:     }
39: 
40:     public function openUploadModal($taskId)
41:     {
42:         $this->selectedTaskId = $taskId;
43:         $this->isUploadModalOpen = true;
44:     }
45: 
46:     public function completeTask()
47:     {
48:         $this->validate([
49:             'photo' => 'required|image|max:5120', // Max 5MB
50:         ]);
51: 
52:         $task = Tugas::where('id', $this->selectedTaskId)
53:             ->where('user_id', auth()->id())
54:             ->firstOrFail();
55: 
56:         // Store photo
57:         $path = $this->photo->store('evidence', 'public');
58: 
59:         LampiranTugas::create([
60:             'task_id' => $task->id,
61:             'file_path' => $path,
62:             'type' => 'PHOTO_EVIDENCE',
63:         ]);
64: 
65:         $task->update(['status' => 'COMPLETED']);
66: 
67:         // Update vehicle status to READY if applicable
68:         if ($task->vehicle_id) {
69:             $task->vehicle->update(['status' => 'READY']);
70:         }
71: 
72:         session()->flash('message', 'Tugas selesai. Terima kasih atas kerja kerasnya!');
73:         $this->isUploadModalOpen = false;
74:         $this->reset(['photo', 'selectedTaskId']);
75:     }
76: }
