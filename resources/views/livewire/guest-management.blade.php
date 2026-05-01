<div class="space-y-10">
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Manajemen Tamu VIP</h2>
            <p class="text-sm text-slate-500 font-medium">Monitoring pergerakan dan pelayanan tamu delegasi.</p>
        </div>
        <div class="flex flex-col md:flex-row w-full xl:w-auto gap-4">
            <div class="relative flex-1 md:min-w-[300px]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" wire:model.live="search" placeholder="Cari Nama Tamu..." class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 shadow-sm dark:text-white font-bold transition-all">
            </div>
            <select wire:model.live="filterType" class="py-3.5 pl-6 pr-10 bg-white dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 shadow-sm dark:text-white font-bold transition-all">
                <option value="">Semua Jadwal</option>
                <option value="ARRIVAL">Kedatangan</option>
                <option value="DEPARTURE">Keberangkatan</option>
                <option value="AGENDA">Agenda Utama</option>
            </select>
            <button wire:click="openModal" class="inline-flex items-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-xl shadow-blue-200 dark:shadow-none">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                Tambah Tamu
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-5 rounded-r-2xl shadow-sm" role="alert">
            <p class="text-sm font-bold">{{ session('message') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-8">
        @foreach($guests as $guest)
            <div class="group relative bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-300 hover:-translate-y-1">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">{{ $guest->full_name }}</h3>
                            </div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                                {{ $guest->title ?? 'VIP GUEST' }}
                                <span class="mx-1 text-slate-200">•</span>
                                {{ $guest->institution }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="edit({{ $guest->id }})" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </button>
                            <button onclick="confirm('Hapus tamu ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $guest->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl p-4">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Jadwal Operasional</h4>
                            <div class="space-y-3">
                                @forelse($guest->itineraries->take(2) as $itin)
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center">
                                            <div class="w-1.5 h-1.5 rounded-full mr-3 {{ $itin->type == 'ARRIVAL' ? 'bg-emerald-500' : ($itin->type == 'DEPARTURE' ? 'bg-rose-500' : 'bg-blue-500') }}"></div>
                                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $itin->type }}</span>
                                        </div>
                                        <span class="text-xs font-black text-slate-400">{{ $itin->schedule_time->format('d M, H:i') }}</span>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 font-bold italic">Belum ada agenda terdaftar</p>
                                @endforelse
                            </div>
                        </div>

                        @if($guest->family_members)
                            <div class="flex flex-wrap gap-2">
                                @foreach($guest->family_members as $member)
                                    <span class="px-3 py-1.5 bg-blue-50/50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-blue-100/50 dark:border-blue-900/20">
                                        {{ $member }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="px-8 py-5 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <button class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest hover:underline">Detail Penuh</button>
                    <button class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:text-slate-600">Kelola Itinerary</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="py-6">
        {{ $guests->links() }}
    </div>

    <!-- Modal Form Guest Modern -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="open = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100 dark:border-slate-800">
                <form wire:submit.prevent="{{ $guestId ? 'update' : 'store' }}">
                    <div class="p-10">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">
                            {{ $guestId ? 'Edit Data Tamu' : 'Registrasi Tamu VIP' }}
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Sesuai Identitas</label>
                                <input type="text" wire:model="full_name" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                @error('full_name') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Gelar / Pangkat</label>
                                    <input type="text" wire:model="title" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Instansi / Organisasi</label>
                                    <input type="text" wire:model="institution" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-3">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Anggota Keluarga / Pendamping</label>
                                    <button type="button" wire:click="addFamily" class="inline-flex items-center text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 dark:bg-blue-900/30 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-all">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                                        Tambah
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($family_members as $index => $member)
                                        <div class="flex items-center group/item">
                                            <input type="text" wire:model="family_members.{{ $index }}" placeholder="Nama Anggota" class="flex-1 px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold text-sm transition-all">
                                            <button type="button" wire:click="removeFamily({{ $index }})" class="ml-2 text-slate-300 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-10 py-8 bg-slate-50 dark:bg-slate-800/50 flex flex-row-reverse gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-10 py-4 rounded-2xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                            Simpan Registrasi
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
