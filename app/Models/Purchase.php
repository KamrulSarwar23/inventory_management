<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'shipping_address',
        'purchase_total',
        'paid_amount',
        'status_id',
        'discount',
        'vat',
        'remark',
        'warehouse_id',
        'purchase_date',
        'delivery_date',
    ];
}
