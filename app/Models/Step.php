<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }


    public function plantSchedule()
    {
        return $this->belongsTo(PlantSchedule::class);
    }
}
