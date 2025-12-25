<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'work_date',
        'check_in',
        'check_out',
        'check_in_late_minutes',
        'check_out_early_minutes',
        'status',
        'notes',
    ];

    protected $casts = [
        'work_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'check_in_late_minutes' => 'integer',
        'check_out_early_minutes' => 'integer',
    ];

    /**
     * Get the user (staff)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shift
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Calculate check-in status
     */
    public function calculateCheckInStatus()
    {
        if (!$this->check_in || !$this->shift) {
            return null;
        }

        $checkInTime = Carbon::parse($this->check_in);
        $shiftStartTime = Carbon::parse($this->work_date->format('Y-m-d') . ' ' . $this->shift->start_time);

        $diffMinutes = $checkInTime->diffInMinutes($shiftStartTime, false);
        // Negative = early, Positive = late

        $this->check_in_late_minutes = $diffMinutes;
        
        if ($diffMinutes > 15) {
            $this->status = 'late';
        } else {
            $this->status = 'present';
        }

        return $diffMinutes;
    }

    /**
     * Calculate check-out status
     */
    public function calculateCheckOutStatus()
    {
        if (!$this->check_out || !$this->shift) {
            return null;
        }

        $checkOutTime = Carbon::parse($this->check_out);
        $shiftEndTime = Carbon::parse($this->work_date->format('Y-m-d') . ' ' . $this->shift->end_time);

        $diffMinutes = $shiftEndTime->diffInMinutes($checkOutTime, false);
        // Negative = early leave, Positive = late leave

        $this->check_out_early_minutes = -$diffMinutes; // Store as positive for early leave

        if ($diffMinutes > 0 && $this->status === 'present') {
            $this->status = 'early_leave';
        }

        return $diffMinutes;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'success',
            'late' => 'warning',
            'early_leave' => 'info',
            'absent' => 'danger',
            default => 'secondary',
        };
    }
}

