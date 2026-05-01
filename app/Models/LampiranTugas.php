<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['task_id', 'file_path', 'type'])]
class LampiranTugas extends Model
{
    use HasFactory;

    protected $table = 'task_attachments';

    public function task(): BelongsTo
    {
        return $this->belongsTo(Tugas::class, 'task_id');
    }
}
