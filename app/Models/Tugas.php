<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['guest_itinerary_id', 'user_id', 'vehicle_id', 'status', 'notes'])]
class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(AgendaTamu::class, 'guest_itinerary_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'vehicle_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(LampiranTugas::class, 'task_id');
    }
}
