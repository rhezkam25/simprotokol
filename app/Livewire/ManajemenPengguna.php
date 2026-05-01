<?php

namespace App\Livewire;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManajemenPengguna extends Component
{
    use WithPagination;

    public $userId, $name, $email, $password, $role = 'ANGGOTA', $status = 'AKTIF', $phone;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:ADMIN,KOORDINATOR,ANGGOTA',
        'status' => 'required|in:AKTIF,CUTI,SAKIT,BERHALANGAN',
        'phone' => 'nullable|string|max:20',
    ];

    public function render()
    {
        return view('livewire.user-management', [
            'users' => Pengguna::latest()->paginate(10),
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
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'ANGGOTA';
        $this->status = 'AKTIF';
        $this->phone = '';
    }

    public function store()
    {
        $this->validate();

        Pengguna::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password ?: 'password123'),
            'role' => $this->role,
            'status' => $this->status,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $user = Pengguna::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->phone = $user->phone;
        
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|in:ADMIN,KOORDINATOR,ANGGOTA',
            'status' => 'required|in:AKTIF,CUTI,SAKIT,BERHALANGAN',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Pengguna::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'phone' => $this->phone,
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        session()->flash('message', 'User berhasil diperbarui.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Pengguna::find($id)->delete();
        session()->flash('message', 'User berhasil dihapus (soft delete).');
    }
}
