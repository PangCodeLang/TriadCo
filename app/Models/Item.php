<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'name', 'category_id', 'stockin_id', 'quantity', 'price',
    ];

    protected $primaryKey = 'item_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $rules = [
        'name' => 'required|string|max:255|unique:items,name',
        'category_id' => 'required|exists:item_categories,itemctgry_id',
        'stockin_id' => 'required|exists:stock_in,stockin_id',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            $lastItem = Item::orderBy('item_id', 'desc')->first();
            $lastId = $lastItem ? (int) substr($lastItem->item_id, 2) : 0;
            $newId = 'IT' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
            $item->item_id = $newId;
        });
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'category_id', 'itemctgry_id');
    }

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stockin_id', 'stockin_id');
    }
}