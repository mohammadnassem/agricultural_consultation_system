<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Plant;

class PlantSchedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function plant() {
        return $this->belongsTo(Plant::class);
    }


    public function steps(){
        return $this->hasMany(Step::class);
    }
}
