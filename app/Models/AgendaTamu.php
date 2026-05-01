<?php
1: 
2: namespace App\Models;
3: 
4: use Illuminate\Database\Eloquent\Model;
5: 
6: use Illuminate\Database\Eloquent\Attributes\Fillable;
7: use Illuminate\Database\Eloquent\Factories\HasFactory;
8: use Illuminate\Database\Eloquent\Relations\BelongsTo;
9: use Illuminate\Database\Eloquent\Relations\HasOne;
10: 
11: #[Fillable(['guest_id', 'type', 'flight_no', 'pnr_code', 'schedule_time', 'airport_or_location', 'hotel_name'])]
12: class AgendaTamu extends Model
13: {
14:     use HasFactory;
15: 
16:     protected $table = 'guest_itineraries';
17: 
18:     protected function casts(): array
19:     {
20:         return [
21:             'schedule_time' => 'datetime',
22:         ];
23:     }
24: 
25:     public function guest(): BelongsTo
26:     {
27:         return $this->belongsTo(Tamu::class, 'guest_id');
28:     }
29: 
30:     public function task(): HasOne
31:     {
32:         return $this->hasOne(Tugas::class, 'guest_itinerary_id');
33:     }
34: }
