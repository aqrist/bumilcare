<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_number',
        'type',
        'examination_id',
        'prescription_id',
        'amount',
        'payment_method',
        'insurance_number',
        'insurance_provider',
        'status',
        'cashier_id'
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
