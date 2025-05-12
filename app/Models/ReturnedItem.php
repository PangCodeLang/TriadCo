<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    protected $primaryKey = 'item_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'item_id', 
        'quantity', 
        'reason',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}