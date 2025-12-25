<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'description',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Get users assigned to this shift
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get attendances for this shift
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Format time display
     */
    public function getTimeRangeAttribute()
    {
        return date('H:i', strtotime($this->start_time)) . ' - ' . date('H:i', strtotime($this->end_time));
    }
}

