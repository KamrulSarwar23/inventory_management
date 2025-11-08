<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'delivery_date',
        'shipping_address',
        'order_total',
        'paid_amount',
        'remark',
        'status_id',
        'discount',
        'vat',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

   protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
