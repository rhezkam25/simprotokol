<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Pengguna</h3>
                        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Pengguna
                        </a>
                    </div>
    <table class="w-full text-left border-collapse">
        <!-- ... kode tabel di bawahnya ... -->
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-200">
                                <th class="p-3 font-semibold text-sm">Nama</th>
                                <th class="p-3 font-semibold text-sm">Email</th>
                                <th class="p-3 font-semibold text-sm">No. HP</th>
                                <th class="p-3 font-semibold text-sm">Role</th>
                                <th class="p-3 font-semibold text-sm">Status</th>
                                <th class="p-3 font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">{{ $user->phone_number ?? '-' }}</td>
                                <td class="p-3">
                                    <span class="bg-gray-200 text-gray-800 py-1 px-2 rounded text-xs font-bold">
                                        {{ $user->roles->pluck('name')->implode(', ') }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    @if($user->is_active)
                                        <span class="text-green-600 font-bold">Aktif</span>
                                    @else
                                        <span class="text-red-600 font-bold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                    
                                    @if($user->id !== auth()->id()) <!-- Jangan biarkan admin menonaktifkan dirinya sendiri -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?')">Nonaktifkan</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>