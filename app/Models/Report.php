<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id', 'activity', 'user_id',
    ];
    protected static function booted()
    {
        static::creating(function ($report) {
            $lastReport = Report::orderBy('report_id', 'desc')->first();
            $lastId = $lastReport ? (int) substr($lastReport->report_id, 3) : 0;
            $report->report_id = 'REP' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}