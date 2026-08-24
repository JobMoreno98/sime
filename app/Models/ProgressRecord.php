<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressRecord extends Model
{
    protected $fillable = [
        'indicator_code', 'year', 'period_sub', 'actual_value', 'notes', 'captured_by_user_id'
    ];

    protected $casts = [
        'captured_at' => 'datetime',
    ];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_code', 'code');
    }

    public function capturedBy()
    {
        return $this->belongsTo(User::class, 'captured_by_user_id');
    }
}