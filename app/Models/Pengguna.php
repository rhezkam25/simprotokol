<?php
1: 
2: namespace App\Models;
3: 
4: // use Illuminate\Contracts\Auth\MustVerifyEmail;
5: use Database\Factories\UserFactory;
6: use Illuminate\Database\Eloquent\Attributes\Fillable;
7: use Illuminate\Database\Eloquent\Attributes\Hidden;
8: use Illuminate\Database\Eloquent\Factories\HasFactory;
9: use Illuminate\Foundation\Auth\User as Authenticatable;
10: use Illuminate\Notifications\Notifiable;
11: 
12: use Illuminate\Database\Eloquent\SoftDeletes;
13: use Illuminate\Database\Eloquent\Relations\HasMany;
14: 
15: #[Fillable(['name', 'email', 'password', 'role', 'status', 'phone', 'last_assigned_at'])]
16: #[Hidden(['password', 'remember_token'])]
17: class Pengguna extends Authenticatable
18: {
19:     /** @use HasFactory<UserFactory> */
20:     use HasFactory, Notifiable, SoftDeletes;
21: 
22:     protected $table = 'users';
23: 
24:     /**
25:      * Get the attributes that should be cast.
26:      *
27:      * @return array<string, string>
28:      */
29:     protected function casts(): array
30:     {
31:         return [
32:             'email_verified_at' => 'datetime',
33:             'password' => 'hashed',
34:         ];
35:     }
36: 
37:     public function tasks(): HasMany
38:     {
39:         return $this->hasMany(Tugas::class, 'user_id');
40:     }
41: }
