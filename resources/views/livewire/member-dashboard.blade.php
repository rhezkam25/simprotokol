<div class="space-y-8 pb-20">
    <div class="flex flex-col gap-2">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tugas Lapangan</h2>
        <div class="flex items-center text-sm font-bold text-slate-500">
            <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
            Staf: {{ auth()->user()->name }}
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-5 rounded-r-2xl shadow-sm animate-fade-in" role="alert">
            <p class="text-sm font-bold">{{ session('message') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($tasks as $task)
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 p-8 hover:shadow-xl transition-all group">
                <div class="flex justify-between items-start mb-8">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                        {{ $task->status == 'PENDING' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : ($task->status == 'ON_PROGRESS' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800') }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $task->status == 'PENDING' ? 'bg-amber-500' : ($task->status == 'ON_PROGRESS' ? 'bg-blue-500' : 'bg-slate-500') }}"></span>
                        {{ $task->status }}
                    </span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                        {{ $task->itinerary->schedule_time->diffForHumans() }}
                    </span>
                </div>

                <div class="mb-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-2">{{ $task->itinerary->guest->full_name }}</h3>
                    <div class="flex items-center text-slate-500 text-sm font-bold">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        {{ $task->itinerary->type }} @ {{ $task->itinerary->airport_or_location }}
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl p-6 mb-8 flex items-center justify-between border border-slate-100/50 dark:border-slate-800/50">
                    <div class="flex items-center">
                        <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Armada Operasional</p>
                            <p class="text-sm font-black text-slate-900 dark:text-white">{{ $task->vehicle->name ?? 'Mobile Only' }}</p>
                        </div>
                    </div>
                    @if($task->vehicle)
                        <div class="px-3 py-1 bg-slate-900 text-white text-[10px] font-black rounded-lg uppercase">
                            {{ $task->vehicle->license_plate }}
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-3">
                    @if($task->status == 'PENDING')
                        <button wire:click="startTask({{ $task->id }})" class="w-full bg-slate-900 dark:bg-blue-600 hover:bg-slate-800 dark:hover:bg-blue-700 text-white font-black py-5 rounded-[1.5rem] transition-all shadow-xl shadow-slate-200 dark:shadow-none uppercase tracking-widest text-xs">
                            Mulai Operasional
                        </button>
                    @elseif($task->status == 'ON_PROGRESS')
                        <button wire:click="openUploadModal({{ $task->id }})" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-[1.5rem] transition-all shadow-xl shadow-blue-200 dark:shadow-none uppercase tracking-widest text-xs">
                            Selesaikan & Upload Bukti
                        </button>
                    @else
                        <div class="w-full bg-slate-100 dark:bg-slate-800 text-slate-400 font-black py-5 rounded-[1.5rem] text-center uppercase tracking-widest text-xs cursor-not-allowed border border-dashed border-slate-200 dark:border-slate-700">
                            Tugas Telah Tuntas
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border border-dashed border-slate-200 dark:border-slate-800">
                <div class="mb-6 flex justify-center">
                    <div class="p-6 bg-slate-50 dark:bg-slate-800 rounded-full">
                        <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">Semua Beres!</h3>
                <p class="text-slate-400 font-bold">Belum ada tugas baru yang masuk untuk Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Upload Modern -->
    <div x-data="{ open: @entangle('isUploadModalOpen') }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end sm:items-center justify-center min-h-screen">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" @click="open = false" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity"></div>
            
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white dark:bg-slate-900 rounded-t-[3rem] sm:rounded-[3rem] shadow-2xl w-full max-w-md overflow-hidden border border-slate-100 dark:border-slate-800">
                <div class="p-10">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">Laporan Bukti Tugas</h3>
                    
                    <form wire:submit.prevent="completeTask" class="space-y-8">
                        <div class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800/50 border-4 border-dashed border-slate-200 dark:border-slate-700 rounded-[2rem] p-10 hover:border-blue-500 transition-all cursor-pointer relative group">
                            <input type="file" wire:model="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" capture="camera">
                            
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="max-h-64 rounded-2xl shadow-xl z-20">
                                <div class="mt-4 text-[10px] font-black text-blue-600 uppercase">Ketuk untuk mengganti</div>
                            @else
                                <div class="p-6 bg-white dark:bg-slate-900 rounded-full shadow-lg text-slate-400 group-hover:text-blue-600 transition-colors mb-4">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Ambil Foto Bukti</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 text-center">Lampirkan dokumentasi lapangan</p>
                            @endif
                        </div>
                        @error('photo') <span class="text-red-500 text-[10px] font-bold mt-2 text-center block">{{ $message }}</span> @enderror

                        <div class="flex flex-col gap-4">
                            <button type="submit" wire:loading.attr="disabled" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-blue-200 dark:shadow-none uppercase tracking-widest text-xs disabled:opacity-50">
                                <span wire:loading.remove>Selesaikan & Kirim Laporan</span>
                                <span wire:loading>Sedang Mengirim...</span>
                            </button>
                            <button type="button" @click="open = false" class="w-full text-slate-400 font-bold py-2 uppercase tracking-widest text-[10px] hover:text-slate-600">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
