<?php
1: 
2: namespace App\Livewire;
3: 
4: use App\Models\Tamu;
5: use Livewire\Component;
6: use Livewire\WithPagination;
7: use Livewire\Attributes\Layout;
8: 
9: #[Layout('layouts.app')]
10: class ManajemenTamu extends Component
11: {
12:     use WithPagination;
13: 
14:     public $search = '';
15:     public $filterType = '';
16:     
17:     // Guest Form
18:     public $guestId, $full_name, $title, $institution, $family_members = [];
19:     public $isModalOpen = false;
20: 
21:     // Itinerary Form (Simple for now)
22:     public $itineraries = [];
23: 
24:     protected $rules = [
25:         'full_name' => 'required|min:3',
26:         'title' => 'nullable',
27:         'institution' => 'nullable',
28:     ];
29: 
30:     public function updatingSearch()
31:     {
32:         $this->resetPage();
33:     }
34: 
35:     public function render()
36:     {
37:         $query = Tamu::with('itineraries')
38:             ->where('full_name', 'like', '%' . $this->search . '%');
39: 
40:         if ($this->filterType) {
41:             $query->whereHas('itineraries', function ($q) {
42:                 $q->where('type', $this->filterType);
43:             });
44:         }
45: 
46:         return view('livewire.guest-management', [
47:             'guests' => $query->latest()->paginate(10),
48:         ]);
49:     }
50: 
51:     public function openModal()
52:     {
53:         $this->resetFields();
54:         $this->isModalOpen = true;
55:     }
56: 
57:     public function closeModal()
58:     {
59:         $this->isModalOpen = false;
60:     }
61: 
62:     public function resetFields()
63:     {
64:         $this->guestId = null;
65:         $this->full_name = '';
66:         $this->title = '';
67:         $this->institution = '';
68:         $this->family_members = [];
69:         $this->itineraries = [];
70:     }
71: 
72:     public function addFamily()
73:     {
74:         $this->family_members[] = '';
75:     }
76: 
77:     public function removeFamily($index)
78:     {
79:         unset($this->family_members[$index]);
80:         $this->family_members = array_values($this->family_members);
81:     }
82: 
83:     public function store()
84:     {
85:         $this->validate();
86: 
87:         Tamu::create([
88:             'full_name' => $this->full_name,
89:             'title' => $this->title,
90:             'institution' => $this->institution,
91:             'family_members' => $this->family_members,
92:         ]);
93: 
94:         session()->flash('message', 'Tamu berhasil ditambahkan.');
95:         $this->closeModal();
96:     }
97: 
98:     public function edit($id)
99:     {
100:         $guest = Tamu::findOrFail($id);
101:         $this->guestId = $guest->id;
102:         $this->full_name = $guest->full_name;
103:         $this->title = $guest->title;
104:         $this->institution = $guest->institution;
105:         $this->family_members = $guest->family_members ?? [];
106:         
107:         $this->isModalOpen = true;
108:     }
109: 
110:     public function update()
111:     {
112:         $this->validate();
113: 
114:         $guest = Tamu::findOrFail($this->guestId);
115:         $guest->update([
116:             'full_name' => $this->full_name,
117:             'title' => $this->title,
118:             'institution' => $this->institution,
119:             'family_members' => $this->family_members,
120:         ]);
121: 
122:         session()->flash('message', 'Tamu berhasil diperbarui.');
123:         $this->closeModal();
124:     }
125: 
126:     public function delete($id)
127:     {
128:         Tamu::find($id)->delete();
129:         session()->flash('message', 'Tamu berhasil dihapus.');
130:     }
131: }
