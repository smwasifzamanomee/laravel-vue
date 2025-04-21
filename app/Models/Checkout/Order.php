<?php

namespace App\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'total_quantity',
    ];

    public function order_items()
    {
        return $this->hasMany(Order_items::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
