<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'phone',
        'order_id',
        'payment_id',
        'pdf',
        'signature',
        'amount',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
