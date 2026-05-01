<?php
1: 
2: namespace App\Models;
3: 
4: use Illuminate\Database\Eloquent\Model;
5: 
6: use Illuminate\Database\Eloquent\Attributes\Fillable;
7: use Illuminate\Database\Eloquent\Factories\HasFactory;
8: 
9: #[Fillable(['name', 'license_plate', 'type', 'status'])]
10: class Kendaraan extends Model
11: {
12:     use HasFactory;
13: 
14:     protected $table = 'vehicles';
15: }
