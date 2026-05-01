<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Dispatching Operasional</h2>
            <p class="text-sm text-slate-500 font-medium">Alokasikan tugas protokol secara cerdas dan real-time.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-5 rounded-r-2xl shadow-sm" role="alert">
            <p class="text-sm font-bold">{{ session('message') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tamu & Jadwal</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kategori</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Progres</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Assignee</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @foreach($itineraries as $itin)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-black text-slate-900 dark:text-white">{{ $itin->guest->full_name }}</div>
                                        <div class="text-xs text-slate-400 font-bold uppercase tracking-tighter">{{ $itin->schedule_time->format('d M Y, H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $itin->type == 'ARRIVAL' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : ($itin->type == 'DEPARTURE' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400') }}">
                                    {{ $itin->type }}
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($itin->task)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $itin->task->status == 'COMPLETED' ? 'bg-slate-100 text-slate-500 dark:bg-slate-800' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 animate-pulse' }}">
                                        {{ $itin->task->status }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest italic decoration-2 underline-offset-4 underline">Belum Terjadwal</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if($itin->task)
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $itin->task->user->name }}</div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $itin->task->vehicle->name ?? 'Mobile Only' }}</div>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600">--</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openAssignModal({{ $itin->id }})" class="inline-flex items-center px-5 py-2.5 bg-slate-900 dark:bg-blue-600 hover:bg-slate-800 dark:hover:bg-blue-700 text-white text-xs font-black rounded-xl transition-all shadow-lg shadow-slate-200 dark:shadow-none uppercase tracking-widest">
                                    {{ $itin->task ? 'Re-Assign' : 'Assign' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-slate-50 dark:bg-slate-800/20 border-t border-slate-100 dark:border-slate-800">
            {{ $itineraries->links() }}
        </div>
    </div>

    <!-- Assignment Modal Modern -->
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="open = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 dark:border-slate-800">
                <div class="p-10">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">Assign Tugas Protokol</h3>
                    
                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Pilih Staf Pelaksana</label>
                            <div class="space-y-2">
                                <select wire:model="userId" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                    <option value="">-- Pilih Staf --</option>
                                    @foreach($recommendedUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} (Beban: {{ $user->tasks_count ?? 0 }} Tugas)</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('userId') <span class="text-red-500 text-[10px] font-bold mt-2 ml-2 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Alokasi Armada</label>
                            <select wire:model="vehicleId" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all">
                                <option value="">-- Pilih Kendaraan (Opsional) --</option>
                                @foreach($availableVehicles as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }} [{{ $v->license_plate }}]</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Instruksi Khusus</label>
                            <textarea wire:model="notes" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 dark:text-white font-bold transition-all" rows="3" placeholder="Contoh: Bawa papan nama, koordinasi dengan Paspampres..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="px-10 py-8 bg-slate-50 dark:bg-slate-800/50 flex flex-row-reverse gap-4">
                    <button wire:click="assignTask" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-10 py-4 rounded-2xl transition-all shadow-lg shadow-blue-200 dark:shadow-none uppercase tracking-widest text-xs">
                        Konfirmasi Penugasan
                    </button>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600 font-bold px-6 py-4 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
