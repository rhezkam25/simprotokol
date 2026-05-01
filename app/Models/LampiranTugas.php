<?php
1: 
2: namespace App\Models;
3: 
4: use Illuminate\Database\Eloquent\Model;
5: 
6: use Illuminate\Database\Eloquent\Attributes\Fillable;
7: use Illuminate\Database\Eloquent\Factories\HasFactory;
8: use Illuminate\Database\Eloquent\Relations\BelongsTo;
9: 
10: #[Fillable(['task_id', 'file_path', 'type'])]
11: class LampiranTugas extends Model
12: {
13:     use HasFactory;
14: 
15:     protected $table = 'task_attachments';
16: 
17:     public function task(): BelongsTo
18:     {
19:         return $this->belongsTo(Tugas::class, 'task_id');
20:     }
21: }
