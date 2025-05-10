<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'stockin_id', 'item_id', 'supplier_id', 'quantity', 'price', 'total_price', 'stockin_date',
    ];

    protected $table = 'stock_in';
    protected $primaryKey = 'stockin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $rules = [
        'item_id' => 'required|exists:items,item_id',
        'supplier_id' => 'required|exists:suppliers,supplier_id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'total_price' => 'required|numeric|min:0',
        'stockin_date' => 'required|date',
    ];

    protected static function booted()
    {
        static::creating(function ($stockIn) {
            $lastStockIn = StockIn::orderBy('stockin_id', 'desc')->first();
            $lastId = $lastStockIn ? (int) substr($lastStockIn->stockin_id, 2) : 0;
            $stockIn->stockin_id = 'SI' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}