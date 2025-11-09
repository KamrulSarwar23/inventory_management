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
        'status',
        'discount',
        'vat',
        'remark',
        'warehouse_id',
        'purchase_date',
        'delivery_date',
    ];

    /**
     * Get the purchase details for the purchase.
     */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    /**
     * Get the supplier that owns the purchase.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the status that owns the purchase.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the warehouse that owns the purchase.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}