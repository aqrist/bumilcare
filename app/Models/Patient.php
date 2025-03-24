<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'blood_type',
        'is_pregnant'
    ];

    public function pregnancies()
    {
        return $this->hasMany(Pregnancy::class);
    }

    public function activePregnancy()
    {
        return $this->hasOne(Pregnancy::class)->where('is_active', true);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
