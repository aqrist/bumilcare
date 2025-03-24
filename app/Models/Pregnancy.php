<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregnancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'first_day_of_last_period',
        'estimated_due_date',
        'pregnancy_count',
        'week',
        'is_high_risk',
        'risk_notes',
        'is_active'
    ];

    protected $casts = [
        'first_day_of_last_period' => 'date',
        'estimated_due_date' => 'date',
        'is_high_risk' => 'boolean',
        'is_active' => 'boolean'
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
