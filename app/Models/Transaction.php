<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'user_id', 
        'member_id',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'status',
        'fine',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function details() {
        return $this->hasMany(TransactionDetail::class);
    }
}
