<?php
1: 
2: namespace App\Models;
3: 
4: use Illuminate\Database\Eloquent\Model;
5: 
6: use Illuminate\Database\Eloquent\Attributes\Fillable;
7: use Illuminate\Database\Eloquent\Factories\HasFactory;
8: use Illuminate\Database\Eloquent\Relations\HasMany;
9: 
10: #[Fillable(['full_name', 'title', 'institution', 'family_members'])]
11: class Tamu extends Model
12: {
13:     use HasFactory;
14: 
15:     protected $table = 'guests';
16: 
17:     protected function casts(): array
18:     {
19:         return [
20:             'family_members' => 'array',
21:         ];
22:     }
23: 
24:     public function itineraries(): HasMany
25:     {
26:         return $this->hasMany(AgendaTamu::class, 'guest_id');
27:     }
28: }
