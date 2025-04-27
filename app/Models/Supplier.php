<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id', 'name', 'address', 'number', 'contact_person',
    ];
    protected $primaryKey = 'supplier_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public static $rules = [
        'name' => 'required|string|max:255|unique:suppliers,name',
        'address' => 'required|string|max:255|unique:suppliers,address',
        'number' => 'required|string|max:15|unique:suppliers,number',
        'contact_person' => 'required|string|max:255|unique:suppliers,contact_person',
    ];

    protected static function booted()
    {
        static::creating(function ($supplier) {

            $lastSupplier = Supplier::orderBy('supplier_id', 'desc')->first();

            $lastId = $lastSupplier ? (int) substr($lastSupplier->supplier_id, 1) : 0;
            $newId = 'S' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

            $supplier->supplier_id = $newId;
        });
    }
}