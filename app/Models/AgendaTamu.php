<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['guest_id', 'type', 'flight_no', 'pnr_code', 'schedule_time', 'airport_or_location', 'hotel_name'])]
class AgendaTamu extends Model
{
    use HasFactory;

    protected $table = 'guest_itineraries';

    protected function casts(): array
    {
        return [
            'schedule_time' => 'datetime',
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Tamu::class, 'guest_id');
    }

    public function task(): HasOne
    {
        return $this->hasOne(Tugas::class, 'guest_itinerary_id');
    }
}
