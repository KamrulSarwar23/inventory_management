<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'qty',
        'price',
        'vat',
        'discount',
    ];

    /**
     * Get the purchase that owns the purchase detail.
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the product that owns the purchase detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}