<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Axis extends Model
{
    protected $guarded = [];
    
    public function themes()
    {
        return $this->hasMany(Theme::class, 'axis_id', 'id');
    }

    public function calculateProgressPercentage()
    {
        return $this->average_percentage;
    }

    protected function progressStyles(): Attribute
    {
        return Attribute::make(
            get: function () {
                $percentage = $this->progress_percentage ?? 0;

                if ($percentage >= 75) {
                    return [
                        'color'  => 'bg-emerald-500',
                        'border' => 'border-l-purple-600',
                    ];
                }

                if ($percentage >= 50) {
                    return [
                        'color'  => 'bg-blue-600',
                        'border' => 'border-l-blue-600',
                    ];
                }

                if ($percentage >= 35) {
                    return [
                        'color'  => 'bg-amber-500',
                        'border' => 'border-l-amber-500',
                    ];
                }

                return [
                    'color'  => 'bg-rose-500',
                    'border' => 'border-l-rose-500',
                ];
            }
        );
    }
}
