<?php

namespace App\Livewire;

use App\Models\Tamu;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManajemenTamu extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    
    public $guestId, $full_name, $title, $institution, $family_members = [];
    public $isModalOpen = false;
    public $itineraries = [];

    protected $rules = [
        'full_name' => 'required|min:3',
        'title' => 'nullable',
        'institution' => 'nullable',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Tamu::with('itineraries')
            ->where('full_name', 'like', '%' . $this->search . '%');

        if ($this->filterType) {
            $query->whereHas('itineraries', function ($q) {
                $q->where('type', $this->filterType);
            });
        }

        return view('livewire.guest-management', [
            'guests' => $query->latest()->paginate(10),
        ]);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetFields()
    {
        $this->guestId = null;
        $this->full_name = '';
        $this->title = '';
        $this->institution = '';
        $this->family_members = [];
        $this->itineraries = [];
    }

    public function addFamily()
    {
        $this->family_members[] = '';
    }

    public function removeFamily($index)
    {
        unset($this->family_members[$index]);
        $this->family_members = array_values($this->family_members);
    }

    public function store()
    {
        $this->validate();

        Tamu::create([
            'full_name' => $this->full_name,
            'title' => $this->title,
            'institution' => $this->institution,
            'family_members' => $this->family_members,
        ]);

        session()->flash('message', 'Tamu berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $guest = Tamu::findOrFail($id);
        $this->guestId = $guest->id;
        $this->full_name = $guest->full_name;
        $this->title = $guest->title;
        $this->institution = $guest->institution;
        $this->family_members = $guest->family_members ?? [];
        
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate();

        $guest = Tamu::findOrFail($this->guestId);
        $guest->update([
            'full_name' => $this->full_name,
            'title' => $this->title,
            'institution' => $this->institution,
            'family_members' => $this->family_members,
        ]);

        session()->flash('message', 'Tamu berhasil diperbarui.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Tamu::find($id)->delete();
        session()->flash('message', 'Tamu berhasil dihapus.');
    }
}
