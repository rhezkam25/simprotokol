<?php
1: 
2: namespace App\Livewire\Actions;
3: 
4: use Illuminate\Support\Facades\Auth;
5: use Illuminate\Support\Facades\Session;
6: 
7: class Keluar
8: {
9:     /**
10:      * Log the current user out of the application.
11:      */
12:     public function __invoke(): void
13:     {
14:         Auth::guard('web')->logout();
15: 
16:         Session::invalidate();
17:         Session::regenerateToken();
18:     }
19: }
