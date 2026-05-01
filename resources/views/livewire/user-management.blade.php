<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Manajemen Pengguna</h2>
            <p class="text-sm text-slate-500 font-medium">Kelola staf protokol dan hak akses operasional mereka.</p>
        </div>
        <button wire:click="openModal" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-2xl transition-all shadow-xl shadow-blue-200 dark:shadow-none hover:-translate-y-0.5 active:translate-y-0">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
            Tambah User
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-5 rounded-r-2xl shadow-sm animate-fade-in" role="alert">
            <p class="text-sm font-bold">{{ session('message') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Identitas Staf</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kontak & Email</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Otoritas</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 flex-shrink-0 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-lg shadow-inner">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-black text-slate-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium italic">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $user->email }}</div>
                                <div class="text-xs text-slate-400">{{ $user->phone ?? 'Belum ada nomor' }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 rounded-xl text-[10px] font-black tracking-tighter uppercase {{ $user->role == 'ADMIN' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : ($user->role == 'KOORDINATOR' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black uppercase {{ $user->status == 'AKTIF' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $user->status == 'AKTIF' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $user->id }})" class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>
                                    <button onclick="confirm('Hapus staf ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $user->id }})" class="text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-slate-50 dark:bg-slate-800/20 border-t border-slate-100 dark:border-slate-800">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Modern -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="open = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 dark:border-slate-800">
                <form wire:submit.prevent="{{ $userId ? 'update' : 'store' }}">
                    <div class="p-10">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">
                            {{ $userId ? 'Edit Profil Staf' : 'Tambah Staf Baru' }}
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                <input type="text" wire:model="name" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                @error('name') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Email</label>
                                <input type="email" wire:model="email" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                @error('email') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Otoritas</label>
                                    <select wire:model="role" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="KOORDINATOR">KOORDINATOR</option>
                                        <option value="ANGGOTA">ANGGOTA</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Saat Ini</label>
                                    <select wire:model="status" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                        <option value="AKTIF">AKTIF</option>
                                        <option value="CUTI">CUTI</option>
                                        <option value="SAKIT">SAKIT</option>
                                        <option value="BERHALANGAN">BERHALANGAN</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Telepon</label>
                                <input type="text" wire:model="phone" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                @error('phone') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-10 py-8 bg-slate-50 dark:bg-slate-800/50 flex flex-row-reverse gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-4 rounded-2xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                            Simpan Data
                        </button>
                        <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-600 font-bold px-6 py-4 transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
