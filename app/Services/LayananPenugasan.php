<?php

namespace App\Services;

use App\Models\Pengguna;
use App\Models\Kendaraan;

class LayananPenugasan
{
    /**
     * Get the best available staff member based on workload and round-robin.
     */
    public function getRecommendedAssignee()
    {
        return Pengguna::where('role', 'ANGGOTA')
            ->where('status', 'AKTIF')
            ->withCount(['tasks' => function ($query) {
                $query->whereIn('status', ['PENDING', 'ON_PROGRESS']);
            }])
            ->orderBy('tasks_count', 'asc')
            ->orderBy('last_assigned_at', 'asc')
            ->first();
    }

    /**
     * Get available vehicles of a specific type.
     */
    public function getAvailableVehicles($type = null)
    {
        $query = Kendaraan::where('status', 'READY');
        
        if ($type) {
            $query->where('type', $type);
        }

        return $query->get();
    }
}
