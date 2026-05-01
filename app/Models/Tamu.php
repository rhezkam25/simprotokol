<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['full_name', 'title', 'institution', 'family_members'])]
class Tamu extends Model
{
    use HasFactory;

    protected $table = 'guests';

    protected function casts(): array
    {
        return [
            'family_members' => 'array',
        ];
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(AgendaTamu::class, 'guest_id');
    }
}
