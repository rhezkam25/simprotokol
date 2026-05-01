<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'license_plate', 'type', 'status'])]
class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
}
