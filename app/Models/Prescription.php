<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'prescription_number',
        'status',
        'pharmacist_id'
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function pharmacist()
    {
        return $this->belongsTo(User::class, 'pharmacist_id');
    }

    public function details()
    {
        return $this->hasMany(PrescriptionDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
