<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in'; 
    protected $fillable = [
        'stockin_id', 'supplier_id', 'id', 'stock_in_date',
    ];

    protected $primaryKey = 'stockin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'stockin_id', 'stockin_id');
    }
}